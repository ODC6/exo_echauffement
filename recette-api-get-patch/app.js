const express = require('express');
const app = express();
const cors = require('cors');


const corsOptions = {
    origin: '*',
    optionsSuccessStatus: 200
};
app.use(cors(corsOptions));


const statRoutes = require('./api/routes/stat');


app.use('/api/v1/stats', statRoutes);

module.exports = app;
