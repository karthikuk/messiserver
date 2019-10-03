const http = require('http');
const net = require('net');
const cp = require('child_process');
const {
    execSync
} = cp;


const url = require('url');

const querystring = require('querystring');
const { parse } = querystring
// const sub1 = cp.fork(`${__dirname}/sub1.js`);
// const sub2 = cp.fork(`${__dirname}/sub2.js`);
// const sub3 = cp.fork(`${__dirname}/sub3.js`);
// const sub4 = cp.fork(`${__dirname}/sub4.js`);
// const sub5 = cp.fork(`${__dirname}/sub5.js`);
// const sub6 = cp.fork(`${__dirname}/sub6.js`);
// const sub7 = cp.fork(`${__dirname}/sub7.js`);
// const sub8 = cp.fork(`${__dirname}/sub8.js`);
// const sub9 = cp.fork(`${__dirname}/sub9.js`);
// const sub10 = cp.fork(`${__dirname}/sub10.js`);




const server = http.createServer((req, res) => {

    
    let reqOptions = {

        method: req.method,

        url: new url.URL(`http://${req.headers.host}${req.url}`)

    }


    let formdata = '';

    req.on('data', chunk => {
        formdata = parse(chunk.toString());
    });


    req.on('end', () => {

        const postData = querystring.stringify(formdata);
    
        const options = {
            hostname: reqOptions.url.hostname,
            port: 8000,
            path: reqOptions.url.pathname,
            method: req.method,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Content-Length': Buffer.byteLength(postData)
            }
        };



            
        const request = http.request(options, (resp) => {
        
            resp.setEncoding('utf8');

            resp.on('data', (chunk) => {

                
                if(chunk.includes('redirect::>')){

                    let redirect = chunk.split('redirect::>').pop()

                    if(redirect) {
                        res.writeHead(302, {
                            'Location': redirect
                        });
                    }
                }
              
                res.write(chunk.toString());
            });
            
            resp.on('end', () => {
                res.end();
            });
        });
        
        request.on('error', (e) => {
            console.error(`problem with request: ${e.message}`);
        });
        
            
        request.write(postData);

        request.end();
    
    });

}).listen(3000);



