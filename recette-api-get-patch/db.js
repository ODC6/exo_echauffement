const mysql = require('mysql');

const connection = mysql.createConnection({
    hhost: 'localhost',
    port:'3306',
    user: 'root',
    password: '',
    database: 'recette_db'
});

connection.connect((err) => {
    if (err) throw err;
    console.log('Connecté à la base de données MySQL');
});

module.exports = connection;
