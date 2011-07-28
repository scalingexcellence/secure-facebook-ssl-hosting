var exec = require("child_process").exec;
var http = require("http");
var url = require("url");

process.on('uncaughtException', function (err) {
  console.log('Caught exception: ' + err);
});

// Looking upt hostnames in port 4233
http.createServer(
    function onRequest(request, response) {
        function rex(response,cb,re) {
            response.writeHead(200, {"Content-Type": "text/javascript"});
            response.write(cb+"("+JSON.stringify(re)+")");
            response.end();
        }
    
        var up = url.parse(request.url,true);
        var turl = up.query.url, cb = up.query.callback;
        if (turl&&cb) {
            turl = turl.replace(/https?:\/\//, "");
            tpath = "";
            if (turl.indexOf("/") != -1) {
                tpath = turl.replace(/.*?\//,"")
            }
            turl = turl.replace(/\/.*/,"")
            if (/([-\w\.]+)+(:\d+)?(\/([\w/_\.]*(\?\S+)?)?)?/.test(turl) && /[a-zA-Z0-9_]+/.test(cb)) {
                var excv = "/root/shost/index.sh " + turl;
                exec(excv, function(error, stdout, stderr) {
                    console.log('Request: ' + excv + ' for: ' + cb + " | " + tpath);
                    re=eval('('+stdout+')');
                    if (re.dom!='') re.dom='https://'+re.dom+(re.type==2?'/~[username]/':'/')+tpath;
                    rex(response,cb,re);
                });
                return;
            }
        }
        rex(response,cb,{message:"This doesn't look like a valid url",dom:'',type:4});
    }
).listen(4233);

if (false) {
    // A small http server for tests
    var path = require('path'), paperboy = require('./paperboy');
    http.createServer(function(req, res) {
      var ip = req.connection.remoteAddress;
      paperboy
        .deliver(path.dirname(__filename), req, res)
        .addHeader('Expires', 300)
        .addHeader('X-PaperRoute', 'Node')
    }).listen(80);
}
