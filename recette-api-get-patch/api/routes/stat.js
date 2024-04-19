const express = require('express')
const router = express.Router()
const db = require('../../db')


router.get('/data-count', (req, res, next) => {
    db.query('SELECT (SELECT COUNT(*) FROM users) as table1Count, (SELECT COUNT(*) FROM category) as table2Count, (SELECT COUNT(*) FROM dish) as table3Count', (err, results) => {
        if (err) {
            console.log(err);
        }

        return res.jsonp(results)
    })
})

router.get('/comments-by-dish', async (req, res) => {
    try {
        const query = `
            SELECT d.dish_name AS dish, COUNT(c.id) AS comment_count
            FROM dish d
            LEFT JOIN reviews c ON d.id = c.dish_id
            GROUP BY d.dish_name;
        `;

        db.query(query, (err, results) => {
            console.log(err);
            res.json(results);
        });

    } catch (error) {
        console.log(error);
        res.status(500).json({ message: "Erreur lors de la récupération des données." });
    }
});


router.get('/comments-index', (req, res) => {
    try {
        db.query(`
    SELECT reviews.*, dish.dish_name, users.name 
    FROM reviews 
    INNER JOIN dish ON reviews.dish_id = dish.id 
    INNER JOIN users ON reviews.user_id = users.id
    LIMIT 5
`, (err, results) => {
            if (err) {
                console.log(err);
                return res.status(500).json({ error: 'Database error' });
            }

            return res.json(results);
        });

    } catch (error) {

    }
})


router.get('/rank', (req, res) => {
    const filter = req.query.filter || 'best'; // Par défaut, filtre sur les mieux notés

    let order = 'DESC';
    if (filter === 'worst') {
        order = 'ASC';
    }

    try {
        db.query(`
            SELECT dish.dish_name, AVG(reviews.mark) AS average_mark
            FROM dish
            INNER JOIN reviews ON dish.id = reviews.dish_id
            GROUP BY dish.id, dish.dish_name
            ORDER BY average_mark ${order}
            LIMIT 5;
        `, (err, results) => {
            if (err) {
                console.log(err);
                return res.status(500).json({ message: 'Erreur lors de la récupération des données.' });
            }

            return res.json(results);
        });
    } catch (error) {
        console.error(error);
        return res.status(500).json({ message: 'Une erreur est survenue.' });
    }
});



module.exports = router