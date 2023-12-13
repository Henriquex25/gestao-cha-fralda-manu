// Supports ES6
import { create } from "venom-bot";
import express from "express";

const app = express();
const port = 3000;

app.use(express.urlencoded({ extended: true }));
app.use(express.json());

app.get("/", (req, res) => {
    res.send("Hello World!");
});

app.listen(port, () => console.log(`Example app listening on port ${port}`));

let api = null;

create({
    session: "gestao-cha-fralda-manu", //name of session
})
    .then((client) => {
        start(client);

        api = client;
    })
    .catch((erro) => {
        console.log(erro);
    });

const start = (client) => {
    app.post("/send-message", (request, response) => {
        const number = request.body.number;
        const message = request.body.message;

        sendMessage(client, number, message);

        response.send({ success: true });
    });
};

const sendMessage = (client, number, message, forGroup = false) => {
    const suffix = forGroup === true ? "@g.us" : "@c.us";

    client.sendText(`55${number}${suffix}`, message);
};

app.post("/send-teste", (request, response) => {
    const number = request.body.number;
    const message = request.body.message;

    sendMessage(api, number, message);

    response.send({ success: true });
});
