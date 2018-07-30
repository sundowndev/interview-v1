"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
//import * as bodyParser from "body-parser";
const express = require("express");
const http = require("http");
let app = express();
app.set('view engine', 'twig');
app.set('views', __dirname + '/views');
app.use(express.static(__dirname + 'public'));
app.get('/', (req, res) => {
    res.render('index');
});
app.get('/login', (req, res) => {
    res.render('login');
});
app.get('/register', (req, res) => {
    res.render('register');
});
app.get('/task/{id}', (req, res) => {
    //res.render('index', {title: 'Hey', message: 'Hello there!'});
});
app.get('/task/{id}/edit', (req, res) => {
    //res.render('index', {title: 'Hey', message: 'Hello there!'});
});
let httpPort = 3000;
app.set("port", httpPort);
let httpServer = http.createServer(app);
// listen on provided ports
httpServer.listen(httpPort, (data) => {
    console.log(`Listening on port ${httpPort}`);
});
