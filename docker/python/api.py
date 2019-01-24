# Recommender Service API

# Import framework
from flask import Flask
from flask_restful import Resource, Api
import sys
import subprocess

# Instantiate the app
app = Flask(__name__)
api = Api(app)

class Content(Resource):
    def get(self):
		recipe = request.args.get('recipe')
		amount = request.args.get('amount')
		output = subprocess.check_output([sys.executable, "content.py", recipe, amount])
        return {'recipes': output}
		
class User(Resource):
    def get(self):
		recipe = request.args.get('recipe')
		rating = request.args.get('rating')
		user = request.args.get('user')
		output = subprocess.check_output([sys.executable, "user.py", recipe, rating, user])
        return {'recipe': output}

# Create routes
api.add_resource(Content, '/content')
api.add_resource(User, '/user')

# Run the application
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80, debug=True)
