/**
 * Modified version of jsVideoUrlParser - https://github.com/Zod-/jsVideoUrlParser
 */
//parses strings like 1h30m20s to seconds
/*jshint unused:false */
function videoUrlParser_getTime(timeString) {
/*jshint unused:true */
  "use strict";
  var totalSeconds = 0,
    timeValues = {
      's': 1,
      'm': 1 * 60,
      'h': 1 * 60 * 60,
      'd': 1 * 60 * 60 * 24,
      'w': 1 * 60 * 60 * 24 * 7
    },
    timePairs;

  //is the format 1h30m20s etc
  if (!timeString.match(/^(\d+[smhdw]?)+$/)) {
    return 0;
  }
  //expand to "1 h 30 m 20 s" and split
  timeString = timeString.replace(/([smhdw])/g, ' $1 ').trim();
  timePairs = timeString.split(' ');

  for (var i = 0; i < timePairs.length; i += 2) {
    totalSeconds += parseInt(timePairs[i], 10) * timeValues[timePairs[i + 1] || 's'];
  }
  return totalSeconds;
}


function videoUrlParser() {
  "use strict";
  this.plugins = {};
}

videoUrlParser.prototype.parse = function(url) {
  "use strict";
  var th = this,
    match = url.match(/(?:https?:\/\/)?(?:[^\.]+\.)?(\w+)\./i),
    provider = match ? match[1] : undefined,
    result;
  if (match && provider && th.plugins[provider] && th.plugins[provider].parse) {
    result = th.plugins[provider].parse.call(this, url);
    if (result) {
      result.provider = th.plugins[provider].provider;
      return result;
    }
  }
  return undefined;
};
videoUrlParser.prototype.bind = function(plugin) {
  "use strict";
  var th = this;
  th.plugins[plugin.provider] = plugin;
  if (plugin.alternatives) {
    for (var i = 0; i < plugin.alternatives.length; i += 1) {
      th.plugins[plugin.alternatives[i]] = plugin;
    }
  }
};
videoUrlParser.prototype.create = function(op) {
  "use strict";
  var th = this,
    vi = op.videoInfo;
  op.format = op.format || 'short';
  if (th.plugins[vi.provider] && th.plugins[vi.provider].create) {
    return th.plugins[vi.provider].create.call(this, op);
  }
  return undefined;
};
/*jshint unused:true */
var videoParser = new videoUrlParser();
/*jshint unused:false */

videoParser.bind({
  'provider': 'dailymotion',
  'alternatives': ['dai'],
  'parse': function (url) {
    "use strict";
    var match,
      id,
      startTime,
      result = {};

    match = url.match(/(?:\/video|ly)\/([A-Za-z0-9]+)/i);
    id = match ? match[1] : undefined;

    match = url.match(/[#\?&]start=([A-Za-z0-9]+)/i);
    startTime = match ? videoUrlParser_getTime(match[1]) : undefined;

    if (!id) {
      return undefined;
    }
    result.mediaType = 'video';
    result.id = id;
    if (startTime) {
      result.startTime = startTime;
    }
    return result;
  },
  'create': function (op) {
    "use strict";
    var vi = op.videoInfo;
    if (vi.startTime) {
      return 'https://dailymotion.com/video/' + vi.id + '?start=' + vi.startTime;
    }

    if (op.format === 'short') {
      return 'https://dai.ly/' + vi.id;
    }

    return 'https://dailymotion.com/video/' + vi.id;
  }
});

videoParser.bind({
  'provider': 'twitch',
  'parse': function (url) {
    "use strict";
    var match,
      id,
      channel,
      idPrefix,
      result = {};

    match = url.match(/twitch\.tv\/(\w+)(?:\/(.)\/(\d+))?/i);
    channel = match ? match[1] : undefined;
    idPrefix = match ? match[2] : undefined;
    id = match ? match[3] : undefined;

    match = url.match(/(?:\?channel|\&utm_content)=(\w+)/i);
    channel = match ? match[1] : channel;

    if (!channel) {
      return undefined;
    }
    if (id) {
      result.mediaType = 'video';
      result.id = id;
      result.idPrefix = idPrefix;
    } else {
      result.mediaType = 'stream';
    }
    result.channel = channel;

    return result;
  },
  'create': function (op) {
    "use strict";
    var vi = op.videoInfo;
    if (vi.mediaType === 'stream') {
      return 'https://twitch.tv/' + vi.channel;
    }

    return 'https://twitch.tv/' + vi.channel + '/' + vi.idPrefix + '/' + vi.id;
  }
});

videoParser.bind({
  'provider': 'vimeo',
  'alternatives': ['vimeopro'],
  'parse': function (url) {
    "use strict";
    var match,
      id;
    match = url.match(/(?:\/(?:channels\/[\w]+|(?:album\/\d+\/)?videos?))?\/(\d+)/i);
    id = match ? match[1] : undefined;
    if (!id) {
      return undefined;
    }
    return {
      'mediaType': 'video',
      'id': id
    };
  },
  'create': function (op) {
    "use strict";
    return 'https://vimeo.com/' + op.videoInfo.id;
  }
});

videoParser.bind({
  'provider': 'youtube',
  'alternatives': ['youtu'],
  'parse': function (url) {
    "use strict";
    var match,
      id,
      playlistId,
      playlistIndex,
      startTime,
      result = {};
	  
	// use the regex of Loofer @ stackoverflow.com instead (http://stackoverflow.com/a/27728417)
    match = url.match(/^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/);
    id = match ? match[1] : undefined;

    match = url.match(/list=([\w\-]+)/i);
    playlistId = match ? match[1] : undefined;

    match = url.match(/index=(\d+)/i);
    playlistIndex = match ? Number(match[1]) : undefined;

    match = url.match(/[#\?&](?:star)?t=([A-Za-z0-9]+)/i);
    startTime = match ? videoUrlParser_getTime(match[1]) : undefined;

    if (id) {
      result.mediaType = 'video';
      result.id = id;
      if (playlistId) {
        result.playlistId = playlistId;
        if (playlistIndex) {
          result.playlistIndex = playlistIndex;
        }
      }
      if (startTime) {
        result.startTime = startTime;
      }
    } else if (playlistId) {
      result.mediaType = 'playlist';
      result.playlistId = playlistId;
    } else {
      return undefined;
    }

    return result;
  },
  'create': function (op) {
    "use strict";
    var url,
      vi = op.videoInfo;
    if (vi.mediaType === 'playlist') {
      return 'https://youtube.com/playlist?feature=share&list=' + vi.playlistId;
    }

    if (vi.playlistId) {
      url = 'https://youtube.com/watch?v=' + vi.id + '&list=' + vi.playlistId;
      if (vi.playlistIndex) {
        url += '&index=' + vi.playlistIndex;
      }
    } else {
      if (op.format === 'short') {
        url = 'https://youtu.be/' + vi.id;
      } else {
        url = 'https://youtube.com/watch?v=' + vi.id;
      }
    }

    if (vi.startTime) {
      url += '#t=' + vi.startTime;
    }
    return url;
  }
});

/**
 * For testing
 */
/*
var urls = [
    '//www.youtube-nocookie.com/embed/up_lNV-yoK4?rel=0',
    'http://www.youtube.com/user/Scobleizer#p/u/1/1p3vcRhsYGo',
    'http://www.youtube.com/watch?v=cKZDdG9FTKY&feature=channel',
    'http://www.youtube.com/watch?v=yZ-K7nCVnBI&playnext_from=TL&videos=osPknwzXEas&feature=sub',
    'http://www.youtube.com/ytscreeningroom?v=NRHVzbJVx8I',
    'http://www.youtube.com/user/SilkRoadTheatre#p/a/u/2/6dwqZw0j_jY',
    'http://youtu.be/6dwqZw0j_jY',
    'http://www.youtube.com/watch?v=6dwqZw0j_jY&feature=youtu.be',
    'http://youtu.be/afa-5HQHiAs',
    'http://www.youtube.com/user/Scobleizer#p/u/1/1p3vcRhsYGo?rel=0',
    'http://www.youtube.com/watch?v=cKZDdG9FTKY&feature=channel',
    'http://www.youtube.com/watch?v=yZ-K7nCVnBI&playnext_from=TL&videos=osPknwzXEas&feature=sub',
    'http://www.youtube.com/ytscreeningroom?v=NRHVzbJVx8I',
    'http://www.youtube.com/embed/nas1rJpm7wY?rel=0',
    'http://www.youtube.com/watch?v=peFZbP64dsU',
    'http://youtube.com/v/dQw4w9WgXcQ?feature=youtube_gdata_player',
    'http://youtube.com/vi/dQw4w9WgXcQ?feature=youtube_gdata_player',
    'http://youtube.com/?v=dQw4w9WgXcQ&feature=youtube_gdata_player',
    'http://www.youtube.com/watch?v=dQw4w9WgXcQ&feature=youtube_gdata_player',
    'http://youtube.com/?vi=dQw4w9WgXcQ&feature=youtube_gdata_player',
    'http://youtube.com/watch?v=dQw4w9WgXcQ&feature=youtube_gdata_player',
    'http://youtube.com/watch?vi=dQw4w9WgXcQ&feature=youtube_gdata_player',
    'http://youtu.be/dQw4w9WgXcQ?feature=youtube_gdata_player',
	'http://www.vimeo.com/7058755',
	'http://www.youtube.com/watch?v=yQaAGmHNn9s&list=PL46F0A159EC02DF82#t=1m4',
	'http://www.youtube.com/watch?v=yQaAGmHNn9s&list=PL46F0A159EC02DF82'
];

for (i = 0; i < urls.length; ++i) {
    console.log( videoParser.parse(urls[i]) );
}
*/