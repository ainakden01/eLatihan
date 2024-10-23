<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Infographic Slide</title>
        
        <style>
.infographic-container {
    position: absolute;
    top: 200px;
    left: 100px;
    right: 100px;
    bottom: 200px;
    margin: auto;
    width: 80%;
    height: 80%;
    background-color: #f0f0f0;
    padding: 0;
    box-sizing: border-box;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.infographic {
    position: relative;
    width: 200%;
    height: 100%;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.infographic-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    pointer-events: none;
    margin: 0;
    padding: 0;
}

.prev-button, .next-button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #4CAF50;
    color: #fff;
    cursor: pointer;
    font-size: 24px;
}

.prev-button:hover, .next-button:hover {
    background-color: #3e8e41;
}
        </style>
    </head>

    <body>
        <div class="infographic-container">
            <button class="prev-button">&lt;</button>
            <div class="infographic">
                <img src="images/image1.jpeg" alt="Infographic 1" class="infographic-image">
            </div>
            <div class="infographic">
                <img src="images/image2.jpeg" alt="Infographic 2" class="infographic-image">
            </div>
            <div class="infographic">
                <img src="images/image3.jpeg" alt="Infographic 3" class="infographic-image">
            </div>
            <button class="next-button">&gt;</button>
        </div>

        <script src="script.js"></script>

        <script>
            const infographicContainer = document.querySelector('.infographic-container');
            const infographicImages = document.querySelectorAll('.infographic-image');
            const prevButton = document.querySelector('.prev-button');
            const nextButton = document.querySelector('.next-button');

            let currentPage = 0;
            let intervalId;

            infographicImages[currentPage].style.display = 'block';

            prevButton.addEventListener('click', () =>
            {
                clearInterval(intervalId);
                infographicImages[currentPage].style.display = 'none';
                currentPage = (currentPage - 1 + infographicImages.length) % infographicImages.length;
                infographicImages[currentPage].style.display = 'block';
                startInterval();
            });

            nextButton.addEventListener('click', () =>
            {
                clearInterval(intervalId);
                infographicImages[currentPage].style.display = 'none';
                currentPage = (currentPage + 1) % infographicImages.length;
                infographicImages[currentPage].style.display = 'block';
                startInterval();
            });

            function startInterval()
            {
                intervalId = setInterval(() => {
                    infographicImages[currentPage].style.display = 'none';
                    currentPage = (currentPage + 1) % infographicImages.length;
                    infographicImages[currentPage].style.display = 'block';
                }, 5000);
            }

            startInterval();
        </script>
    </body>
</html>