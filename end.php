<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackers Anonymous</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Courier New', Courier, monospace;
            color: #00ff00;
            background: #000;
            overflow: hidden;
        }

        .glitch {
            font-size: 4rem;
            font-weight: bold;
            color: #00ff00;
            text-align: center;
            text-shadow: 0 0 5px #00ff00, 0 0 10px #00ff00, 0 0 20px #00ff00, 0 0 30px #00ff00;
            position: absolute;
            top: 30%;
            width: 100%;
        }

        .glitch::before,
        .glitch::after {
            content: attr(data-text);
            position: absolute;
            left: 0;
            right: 0;
        }

        .glitch::before {
            animation: glitch-anim 2s infinite;
            clip: rect(5px, 9999px, 85px, 0);
            color: #ff0000;
        }

        .glitch::after {
            animation: glitch-anim 2s infinite reverse;
            clip: rect(25px, 9999px, 105px, 0);
            color: #0000ff;
        }

        @keyframes glitch-anim {
            0% {
                transform: translate(0);
            }

            33% {
                transform: translate(-5px, -5px);
            }

            66% {
                transform: translate(5px, 5px);
            }

            100% {
                transform: translate(0);
            }
        }

        .matrix {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .matrix div {
            position: absolute;
            width: 10px;
            height: 100vh;
            font-size: 16px;
            color: #00ff00;
            animation: fall 10s infinite linear;
        }

        .matrix div span {
            display: block;
        }

        @keyframes fall {
            0% {
                transform: translateY(-100%);
            }

            100% {
                transform: translateY(100%);
            }
        }

        footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 1.2rem;
            color: #00ff00;
            text-shadow: 0 0 5px #00ff00, 0 0 10px #00ff00;
        }

        footer .names {
            margin-top: 10px;
            font-style: italic;
        }
    </style>
    <script>
        // Rechargement de la page toutes les 5 secondes
        setTimeout(() => {
            window.location.reload();
        }, 10000);

        // Génération de l'effet Matrix
        document.addEventListener("DOMContentLoaded", () => {
            for (let i = 0; i < 100; i++) {
                const column = document.createElement('div');
                column.style.left = `${Math.random() * 100}vw`;
                column.innerHTML = Array.from({ length: 50 }, () => `<span>${Math.floor(Math.random() * 10)}</span>`).join('');
                document.querySelector('.matrix').appendChild(column);
            }
        });
    </script>
</head>

<body>
    <div class="matrix"></div>

    <div class="glitch" data-text="WELCOME TO THE FSOCIETY">WELCOME TO THE FSOCIETY</div>

    <footer>
        Hackers Legend:
        <div class="names">Kevin Mitnick, Adrian Lamo, George Hotz, Loyd Blankenship, Jonathan James</div>
    </footer>
</body>

</html>
