<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./assets/dist/scheme-purple.css">
</head>
<body>

<div id="stock-portfolio-tracker"></div>

<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script>
    var StockPortfolioTracker = {
        markets: ['nse'],
        color: 'purple',
        pluginUrl: './',
        firebase: {
            auth: true,
            settings: {
                apiKey: "AIzaSyANStzowYhfrm3ZKv77e-gS6IY6xBI_1cA",
                authDomain: "wealthyfy-website.firebaseapp.com",
                projectId: "wealthyfy-website",
                storageBucket: "wealthyfy-website.appspot.com",
                messagingSenderId: "353694442485",
                appId: "1:353694442485:web:e25391f435c7d5e75836bc",
                measurementId: "G-VSSJ508GQJ"
            }
        }
    }
</script>
<script src="./assets/dist/app.js"></script>
</body>
</html>