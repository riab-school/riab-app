(function($) {
    $.fn.SignPad = function(options) {
        // Default options
        const settings = $.extend({
            width       : 400,
            height      : 200,
            lineColor   : '#0000FF',
            lineWidth   : 2,
            userId      : null,
            canvasId    : 'signature-pad',
            onSave      : async ()=>{},
            styles      : {
                clearBtn: "btn",
                undoBtn : "btn",
                saveBtn : ""
            }
        }, options);

        let undoStack = [];

        // Create canvas and buttons dynamically
        this.html(`
            <div class="signature-container">
                <h2 style="text-align: center;" class="text-dark">Sign Here</h2>
                <canvas id="${settings.canvasId}" width="${settings.width}" height="${settings.height}"></canvas>
                <div class="buttons">
                    <button class="${settings.styles.clearBtn}" id="clear">Clear</button>
                    <button class="${settings.styles.undoBtn}" id="undo">Undo</button>
                    <button class="${settings.styles.saveBtn}" id="save">Save</button>
                </div>
            </div>
        `);

        const canvas = this.find('canvas')[0];
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let lastX = 0, lastY = 0;

        // Set canvas drawing properties
        ctx.strokeStyle = settings.lineColor;
        ctx.lineWidth = settings.lineWidth;
        ctx.lineJoin = 'round';
        ctx.lineCap = 'round';

        // Start drawing
        function startDrawing(event) {
            isDrawing = true;
            const { x, y } = getMousePosition(event);
            lastX = x;
            lastY = y;
            ctx.beginPath();
            ctx.moveTo(x, y);

            // Save current canvas state for undo
            undoStack.push(canvas.toDataURL());
        }

        // Draw
        function draw(event) {
            if (!isDrawing) return;
            const { x, y } = getMousePosition(event);
            ctx.lineTo(x, y);
            ctx.stroke();
            lastX = x;
            lastY = y;
        }

        // Stop drawing
        function stopDrawing() {
            isDrawing = false;
            ctx.closePath();
        }

        // Get mouse position
        function getMousePosition(event) {
            const rect = canvas.getBoundingClientRect();
            const x = event.clientX ? event.clientX - rect.left : event.touches[0].clientX - rect.left;
            const y = event.clientY ? event.clientY - rect.top : event.touches[0].clientY - rect.top;
            return { x, y };
        }

        // Undo functionality
        $('#undo').click(() => {
            if (undoStack.length > 0) {
                const lastState = undoStack.pop();
                const img = new Image();
                img.src = lastState;
                img.onload = () => {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0);
                };
            }
        });

        // Clear functionality
        $('#clear').click(() => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        });

        // Save functionality
        $('#save').click(() => {
            const dataURL = canvas.toDataURL('image/png');

            // Save the data, including date and user information
            const postData = {
                userId: settings.userId,
                signature: dataURL,
                _token: settings.csrfToken,
            };

            settings.onSave(postData);

            // Example POST request
            fetch(settings.saveUrl, {
                method: 'POST',
                body: JSON.stringify(postData),
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => response.json())
            .then($('.modal-rekam-signature').modal('hide'))
            .then(data => showSwal(data.status, data.message, true))
            .catch(error => console.error('Error:', error));
        });

        // Drawing event listeners
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('touchstart', startDrawing, { passive: false });
        canvas.addEventListener('touchmove', draw, { passive: false });
        canvas.addEventListener('touchend', stopDrawing);

        return this;
    };
}(jQuery));