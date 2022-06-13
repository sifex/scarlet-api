import { WebSocketServer } from 'ws';

const wss = new WebSocketServer({ port: 2074 });


let files = [
    '@Mod1/test.txt',
    '@Mod2/test.txt',
    '@Mod3/test.txt',
    '@Mod4/test.txt',
    '@Mod5/test.txt',
    '@Mod6/test.txt',
    '@Mod7/test.txt',
    '@Mod8/test.txt',
    '@Mod9/test.txt',
    '@Mod0/test.txt',
]

const asyncWait = ms => new Promise(resolve => setTimeout(resolve, ms))

wss.on('connection', function connection(ws) {
    ws.on('message', async function message(data) {
        data = String.fromCharCode(...data)
        console.log(data)
        if(data.startsWith('Updater|browserConnect')) {
            setTimeout(() => {
                ws.send('Browser|browserConfirmation')
            }, 500)
        } else if(data.startsWith('Updater|locationChange')) {
            ws.send('Browser|UpdateInstallLocation|C:\\Users\\Alex\\Downloads')
        } else if(data.startsWith('Updater|startDownload')) {
            let progress = 0

            for (let i in files) {
                ws.send('Browser|UpdateStatus|Downloading')
                ws.send('Browser|UpdateFile|' + files[i])
                for (let j = 0; j < 10; j++) {
                    progress += (100 / files.length) / 10
                    ws.send('Browser|UpdateProgress|'+ progress)
                    await asyncWait(20)
                }
                ws.send('Browser|UpdateFile|' + files[i])
            }
            ws.send('Browser|Completed')
        }
    });
});