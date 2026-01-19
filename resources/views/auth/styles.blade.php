<style>
* {
    box-sizing: border-box;
}

body {
    font-family: Arial, Helvetica, sans-serif;
    background: linear-gradient(135deg, #4e73df, #c6cad3ff);
    height: 100vh;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.auth-card {
    background: #fff;
    padding: 30px;
    width: 360px;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.auth-card h3 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
}

.form-group {
    margin-bottom: 15px;
}

.auth-card input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 5px;
    border: 1px solid #ccc;
    outline: none;
}

.auth-card input:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 2px rgba(78, 115, 223, 0.15);
}

.auth-card button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.auth-card.login button {
    background: #4e73df;
}

.auth-card.login button:hover {
    background: #2e59d9;
}

.auth-card.register button {
    background: #1cc88a;
}

.auth-card.register button:hover {
    background: #17a673;
}

.error {
    background: #f8d7da;
    color: #842029;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
}

.success {
    background: #d1e7dd;
    color: #0f5132;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
}

.auth-link {
    text-align: center;
    margin-top: 15px;
}

.auth-link a {
    text-decoration: none;
    color: #4e73df;
    font-weight: bold;
}

.auth-link a:hover {
    text-decoration: underline;
}
</style>