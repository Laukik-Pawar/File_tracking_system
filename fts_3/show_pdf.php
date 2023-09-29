<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PDF Viewer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #pdfContainer {
            position: relative;
        }

        #pdfCanvas {
            border: 1px solid black;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
</head>
<body>
    <div>
        <?php
        if (isset($_GET['id'])) {
            $fileId = $_GET['id'];

            // Replace with your database connection code
          
            $host = "localhost";
            $username = "root";
            $dbname = "fts";
            $port = 3307; // Use the appropriate port

            $conn = new mysqli($host, $username, '', $dbname, $port);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch PDF data based on the file ID
            $stmt = $conn->prepare("SELECT attachment FROM files WHERE id = ?");
            $stmt->bind_param("i", $fileId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $pdfData = $row['attachment'];

                // Output the PDF data
                echo '<div id="pdfContainer">';
                echo '<canvas id="pdfCanvas"></canvas>';
                echo '</div>';
            } else {
                echo '<p>File not found.</p>';
                exit();
            }
        } else {
            echo '<p>Invalid request.</p>';
            exit();
        }
        ?>
    </div>
    <div>
            <label for="colorPicker">Select Annotation Color:</label>
            <input type="color" id="colorPicker" onchange="changeColor(this.value)">
            <button onclick="toggleEraser()">Toggle Eraser</button>
        </div>
    <button onclick="prevPage()">Previous Page</button>
    <button onclick="nextPage()">Next Page</button>

    <button onclick="printPDF()">Preview PDF</button>
    <button onclick="saveAnnotations()">Download Annotated PDF</button>
    <script>
        const pdfCanvas = document.getElementById('pdfCanvas');
        const context = pdfCanvas.getContext('2d');
        let pdfDoc = null;
        let pageNum = 1;

        const pdfData = atob('<?php echo base64_encode($pdfData); ?>');
        const binaryData = new Uint8Array(Array.from(pdfData).map(c => c.charCodeAt(0)));

        pdfjsLib.getDocument({
            data: binaryData
        }).promise.then(pdf => {
            pdfDoc = pdf;
            renderPage(pageNum);
        });

        const annotations = []; // Store annotations for each page

function prevPage() {
    if (pageNum > 1) {
        pageNum--;
        renderPage(pageNum);
    }
}

function nextPage() {
    if (pageNum < pdfDoc.numPages) {
        pageNum++;
        renderPage(pageNum);
    }
}

function renderAnnotations(pageNumber) {
    annotations[pageNumber - 1]?.forEach(annotation => {
        context.beginPath();
        context.moveTo(annotation.points[0].x, annotation.points[0].y);
        annotation.points.forEach(point => {
            context.lineTo(point.x, point.y);
        });
        context.strokeStyle = annotation.color;
        context.lineWidth = annotation.lineWidth;
        context.stroke();
    });
}


function renderPage(num) {
    pdfDoc.getPage(num).then(page => {
        const viewport = page.getViewport({
            scale: 1.5
        });
        pdfCanvas.width = viewport.width;
        pdfCanvas.height = viewport.height;

        const renderContext = {
            canvasContext: context,
            viewport: viewport
        };

        context.clearRect(0, 0, pdfCanvas.width, pdfCanvas.height); // Clear the canvas

        page.render(renderContext).promise.then(() => {
            renderAnnotations(num); // Render annotations after rendering the PDF content
        });
    });
}


let isDrawing = false;
let annotationX = 0;
let annotationY = 0;

pdfCanvas.addEventListener('mousedown', startDrawing);
pdfCanvas.addEventListener('mousemove', draw);
pdfCanvas.addEventListener('mouseup', stopDrawing);

function startDrawing(event) {
    isDrawing = true;
    annotationX = event.offsetX;
    annotationY = event.offsetY;
}

let currentColor = 'red';
let isErasing = false;

function changeColor(newColor) {
    currentColor = newColor;
}

function toggleEraser() {
    isErasing = !isErasing;
}

function draw(event) {
    if (!isDrawing) return;

    const x = event.offsetX;
    const y = event.offsetY;

    const annotation = {
        points: [{
            x: annotationX,
            y: annotationY
        }, {
            x,
            y
        }],
        color: isErasing ? 'white' : currentColor,
        lineWidth: isErasing ? 10 : 2
    };

    annotations[pageNum - 1] = annotations[pageNum - 1] || [];
    annotations[pageNum - 1].push(annotation);

    context.beginPath();
    context.moveTo(annotationX, annotationY);
    context.lineTo(x, y);
    context.strokeStyle = annotation.color;
    context.lineWidth = annotation.lineWidth;
    context.stroke();

    annotationX = x;
    annotationY = y;
}

function stopDrawing() {
    isDrawing = false;
}


function getAnnotations() {
    const allAnnotations = [];
    for (let i = 0; i < pdfDoc.numPages; i++) {
        const pageAnnotations = annotations[i] || [];
        allAnnotations.push(...pageAnnotations);
    }
    return allAnnotations;
}


function saveAnnotations() {
// Create a new jsPDF instance
const { jsPDF } = window.jspdf;
var doc = new jsPDF();

// Define dimensions and position for the image
var imgWidth = 210; // Adjust this as needed
var imgHeight = 297; // Adjust this as needed
var xPos = 10; // Adjust this as needed
var yPos = 10; // Adjust this as needed
const base64String = pdf1Data;

// A function to add an image and return a promise
function addImageToPDF(index) {
    return new Promise((resolve) => {
        doc.addImage(base64String[index], 'PNG', xPos, yPos, imgWidth, imgHeight);
        console.log(base64String[index]);
        resolve();
    });
}

// An array to store all the image addition promises
const imagePromises = [];

// Loop through the base64String and add images to the PDF
for (let i = 0; i < base64String.length; i++) {
    if (i > 0) {
        doc.addPage();
    }
    imagePromises.push(addImageToPDF(i));
}

// Wait for all promises to resolve before saving the PDF
Promise.all(imagePromises)
    .then(() => {
        // Save the PDF
        doc.save('output.pdf');
    })
    .catch((error) => {
        console.error('Error adding images to PDF:', error);
    });
}


let pdf1Data = []; // Initialize an array to store PDF page data URIs

function printPDF() {
const printWindow = window.open();
const printDoc = printWindow.document;

for (let i = 1; i <= pdfDoc.numPages; i++) {
pdfDoc.getPage(i).then(page => {
    const viewport = page.getViewport({
        scale: 1.5
    });
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    canvas.width = viewport.width;
    canvas.height = viewport.height;

    const renderContext = {
        canvasContext: context,
        viewport: viewport
    };

    page.render(renderContext).promise.then(() => {
        renderAnnotationsOnCanvas(context, i); // Render annotations on the canvas
        const imageData = canvas.toDataURL();
        pdf1Data.push(imageData); // Store the page image data in the array
        printDoc.write('<img src="' + imageData + '" style="max-width: 100%;">');
        if (i === pdfDoc.numPages) {
            printDoc.close();
            printWindow.onload = function () {
                // pdfData now contains an array of page image data URIs
                // You can use pdfData as needed
                console.log(pdf1Data);
                // Optionally, you can join the page data into a single PDF data URI
                // Now combinedPDFData contains the entire PDF as a single data URI
            };
        }

    });
});
}
}


function renderAnnotationsOnCanvas(context, pageNumber) {
    annotations[pageNumber - 1]?.forEach(annotation => {
        context.beginPath();
        context.moveTo(annotation.points[0].x, annotation.points[0].y);
        annotation.points.forEach(point => {
            context.lineTo(point.x, point.y);
        });
        context.strokeStyle = annotation.color;
        context.lineWidth = annotation.lineWidth;
        context.stroke();
    });
}
    </script>
</body>
</html>
