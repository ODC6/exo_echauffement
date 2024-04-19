const fs = require('fs');
const mysql = require('mysql');
const db = require('./db')


// Chemin du fichier de sortie XML
const OUTPUT_FILE = 'C:/Users/okaar/OneDrive/Bureau/exo_echauffement/output.xml';

// Liste des tables à exporter
const TABLES = ['category', 'dish', 'users', 'admin', 'reviews'];

// Début du fichier XML
let xmlContent = '<?xml version="1.0" encoding="UTF-8"?>\n<database>\n';

// Fonction pour exporter les données d'une table
function exportTable(table, callback) {
    const query = `SELECT * FROM ${table}`;
    db.query(query, (err, results) => {
        if (err) {
            return callback(err);
        }

        let tableXml = `<${table}>\n`;
        for (const row of results) {
            tableXml += '  <row>\n';
            for (const key in row) {
                if (row.hasOwnProperty(key)) {
                    tableXml += `    <${key}>${row[key]}</${key}>\n`;
                }
            }
            tableXml += '  </row>\n';
        }
        tableXml += `</${table}>\n`;

        callback(null, tableXml);
    });
}

// Export des données pour chaque table
function exportTables(tables, callback) {
    let xmlContent = '<?xml version="1.0" encoding="UTF-8"?>\n<database>\n';

    function next(i) {
        if (i < tables.length) {
            exportTable(tables[i], (err, tableXml) => {
                if (err) {
                    return callback(err);
                }

                xmlContent += tableXml;
                next(i + 1);
            });
        } else {
            xmlContent += '</database>';
            callback(null, xmlContent);
        }
    }

    next(0);
}

// Exécution de l'export
exportTables(TABLES, (err, xmlContent) => {
    if (err) {
        console.error('Erreur lors de l\'exportation:', err);
        return;
    }

    fs.writeFile(OUTPUT_FILE, xmlContent, (err) => {
        if (err) {
            console.error('Erreur lors de l\'écriture du fichier:', err);
            return;
        }

        console.log(`Exportation terminée. Les données ont été sauvegardées dans ${OUTPUT_FILE}.`);
    });
});
