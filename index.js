const express = require("express");
const bodyParser = require("body-parser");
const axios = require("axios");
require("dotenv").config();

const app = express();
app.use(bodyParser.json());

const TOKEN = process.env.BOT_TOKEN;
const ADMIN_ID = process.env.ADMIN_ID;
const TELEGRAM_API = `https://api.telegram.org/bot${TOKEN}`;

app.post("/webhook", async (req, res) => {
    const message = req.body.message;
    if (!message || !message.text) return res.sendStatus(200);

    const chatId = message.chat.id;
    const text = message.text;

    if (text === "/start") {
        await axios.post(`${TELEGRAM_API}/sendMessage`, {
            chat_id: chatId,
            text: "Welcome to *AEFA Changer* bot powered by Node.js!",
            parse_mode: "Markdown"
        });
    }

    res.send("OK");
});

app.get("/", (req, res) => {
    res.send("Telegram Bot is running...");
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Bot server running on port ${PORT}`);
});
