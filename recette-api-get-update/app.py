from flask import Flask, request, jsonify
from flask_mysqldb import MySQL
from flask_cors import CORS
from datetime import timedelta


app = Flask(__name__)


app.config['MYSQL_HOST'] = "localhost"
app.config['MYSQL_USER'] = "root"
app.config['MYSQL_PASSWORD'] = ""
app.config['MYSQL_DB'] = "recette_db"

mysql = MySQL(app)
CORS(app)

def serialize_timedelta(td):
    return str(td)

@app.route("/api/v1/category/edit/<int:category_id>", methods=['PUT'])
def edit_category(category_id):
    try:
        data = request.json
        category_name = data.get('category_name')

        if not category_name:
            return jsonify({"message": "Le champ 'category_name' est requis."}), 400

        cur = mysql.connection.cursor()

        cur.execute("UPDATE category SET category_name = %s WHERE id = %s", (category_name, category_id))

        mysql.connection.commit()

        cur.close()

        return jsonify({"message": "Catégorie mise à jour avec succès."}), 200

    except Exception as e:
        return jsonify({"message": "Erreur lors de la mise à jour de la catégorie.", "error": str(e)}), 500
    

@app.route("/api/v1/category/index", methods=['GET'])
def get_categories():
    try:
        cur = mysql.connection.cursor()

        cur.execute('SELECT id, category_name FROM category')

        results = [{"id": row[0], "name": row[1]} for row in cur.fetchall()]

        cur.close()

        return jsonify(results), 200

    except Exception as e:
        return jsonify({"message": "Erreur lors de la récupération des catégories.", "error": str(e)}), 500
    


@app.route("/api/v1/dish/edit/<int:dish_id>", methods=['PUT'])
def edit_dish(dish_id):
    try:
        data = request.json
        dish_name = data.get('dish_name')
        slug = data.get('slug')
        dish_ingredient = data.get('dish_ingredient')
        dish_recette = data.get('dish_recette')
        preparation = data.get('preparation')
        cuissons = data.get('cuissons')
        temps_total = data.get('temps_total')
        id_category = data.get('id_category')

        cur = mysql.connection.cursor()

        cur.execute("""
            UPDATE dish 
            SET dish_name = %s, slug = %s, dish_ingredient = %s, dish_recette = %s, 
                preparation = %s, cuissons = %s, temps_total = %s, id_category = %s
            WHERE id = %s
        """, (dish_name, slug, dish_ingredient, dish_recette, preparation, cuissons, temps_total, id_category, dish_id))

        mysql.connection.commit()

        cur.close()

        return jsonify({"message": "Plat mis à jour avec succès."}), 200

    except Exception as e:
        return jsonify({"message": "Erreur lors de la mise à jour du plat.", "error": str(e)}), 500
    
    
@app.route("/api/v1/dish/index", methods=['GET'])
def get_dishes():
    try:
        cur = mysql.connection.cursor()

        cur.execute("""
                SELECT dish.id, dish_name, slug, dish_ingredient, dish_recette, 
                    TIME_FORMAT(preparation, '%H:%i') as preparation, 
                    TIME_FORMAT(cuissons, '%H:%i') as cuissons, 
                    TIME_FORMAT(temps_total, '%H:%i') as temps_total, 
                    id_category, category.category_name
                FROM dish INNER JOIN category ON dish.id_category = category.id
            """)


        results = cur.fetchall()

        # Convertir les timedelta en chaînes de caractères
        serialized_results = []
        for row in results:
            serialized_row = list(row)
            serialized_row[5] = serialize_timedelta(row[5])
            serialized_row[6] = serialize_timedelta(row[6])
            serialized_row[7] = serialize_timedelta(row[7])
            serialized_results.append(serialized_row)

        cur.close()

        return jsonify(serialized_results), 200

    except Exception as e:
        print("Erreur:", e)  
        return jsonify({"message": "Erreur lors de la récupération des plats.", "error": str(e)}), 500




@app.route("/api/v1/reviews/index", methods=['GET'])
def get_reviews():
    try:
        cur = mysql.connection.cursor()

        cur.execute("""SELECT * FROM reviews INNER JOIN users ON reviews.user_id=users.id""")

        results = cur.fetchall()

        cur.close()

        return jsonify(results), 200

    except Exception as e:
        return jsonify({"message": "Erreur lors de la récupération des plats.", "error": str(e)}), 500


if __name__ == "__main__":
    app.run(debug=True)