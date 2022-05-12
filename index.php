<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coff-IT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <style>
        body {
            height: 95vh;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            background-color: #08bc94;
        }

        #logo-container {
            height: 20em;
            width: 20em;
            padding: 3%;
            border-radius: 50%;
            background-color: #045e49;
        }

        img {
            height: 20em;
            width: 20em;
        }

        span {
            text-align: center;
            width: 100%;
            font-size: 5vh;
            font-family: 'Montserrat', sans-serif;
        }
    </style>
    <div id="logo-container">
        <img src="logo.png">
    </div>
    <span id="text">Coming soon...</span>
    <script>

        const t = document.getElementById("text");
        var index = 0;
        var texts = ["Coming soon", "Coming soon.", "Coming soon..", "Coming soon..."]


        window.setInterval(function(){
            index++
            if(index > texts.length - 1) {
                index = 0;
            }
            t.innerText = texts[index];
        }, 500);
    </script>
</body>
</html>