//import * as bodyParser from "body-parser";
import * as express from "express";
import {Request, Response} from "express";
import * as http from 'http';

let app: express.Application = express();

app.set('view engine', 'twig');
app.set('views', __dirname + '/views');

app.get('/', (req: Request, res: Response) => {
    res.render('index', {title: 'Hey', message: 'Hello there!'});
});

app.get('/task/{id}', (req: Request, res: Response) => {
    //res.render('index', {title: 'Hey', message: 'Hello there!'});
});

app.get('/task/{id}/edit', (req: Request, res: Response) => {
    //res.render('index', {title: 'Hey', message: 'Hello there!'});
});

let httpPort = 3000;
app.set("port", httpPort);
let httpServer = http.createServer(app);

// listen on provided ports
httpServer.listen(httpPort, (data) => {
    console.log(`Listening on port ${httpPort}`)
});