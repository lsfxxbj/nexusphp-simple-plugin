<?php

// 测试导航链接添加

echo '<!DOCTYPE html>
<html>
<head>
    <title>Test Navigation Link</title>
</head>
<body>
    <ul id="mainmenu">
        <li><a href="index.php">Home</a></li>
    </ul>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var mainMenu = document.querySelector("#mainmenu");
            if (mainMenu) {
                var simpleLi = document.createElement("li");
                var simpleLink = document.createElement("a");
                simpleLink.href = "simple-plugin.php";
                simpleLink.innerHTML = "&nbsp;Simple Plugin&nbsp;";
                simpleLi.appendChild(simpleLink);
                mainMenu.appendChild(simpleLi);
                console.log("Simple Plugin link added successfully!");
            }
        });
    </script>
</body>
</html>';