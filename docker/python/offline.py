# Recommender Service

# Import framework
from flask import Flask
from flask_restful import Resource, Api

# Instantiate the app
app = Flask(__name__)
api = Api(app)

class Test(Resource):
    def get(self):
        return {
            'items': ['Button']
        }

# Create routes
api.add_resource(Test, '/')

# Run the application
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80, debug=True)
