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
		start = request.args.get('start')
		amount = request.args.get('amount')
		output = subprocess.check_output([sys.executable, "content.py", start, amount])
        return {'recipes': output}

# Create routes
api.add_resource(Content, '/content')

# Run the application
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80, debug=True)
