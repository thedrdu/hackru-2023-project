from flask import Flask, request, render_template
from search import search, get_recommendations
app = Flask(__name__, static_folder='static')

recommendations = []
inputs = set()

@app.route("/")
def form():
    return render_template("index.html", show_results=False)

@app.route('/', methods=['POST'])
async def form_post():
    if "text" in request.form:
        text = request.form['text']
        data = await search(text)
        if data[0] == 0: #Success
            return render_template("index.html", title=data[1], show_results=True, results_found=True, bad_request=False)
        elif data[0] == 1: #No results found
            return render_template("index.html", title=f"\"{text}\"", show_results=True, results_found=False, bad_request=False)
        else: #Bad request
            return render_template("index.html", title=f"\"{text}\"", show_results=True, results_found=False, bad_request=True)
    elif "title" in request.form:
        title = request.form.get("title")
        inputs.add(title)
        #add to the db at this point
        return render_template("index.html")
        # return 'Title received: {}'.format(title)
    else: #confirm
        for anime in inputs:
            recommendations.extend(await get_recommendations(anime))
        return render_template("results.html", inputs=inputs, recommendations=recommendations)

@app.route("/about")
def main():
    return render_template("about.html")

if __name__ == "__main__":
    app.run(host='0.0.0.0')
