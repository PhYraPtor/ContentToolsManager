// Fonction pour récupéer un un string d'un GET
function $_GET(param) {
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace(
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function( m, key, value ) { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if ( param ) {
        return vars[param] ? vars[param] : null;
    }
    return vars;
}

window.addEventListener('load', function() {
    var editor;
    editor = ContentTools.EditorApp.get();
    editor.init('*[data-editable]', 'data-name');
    ContentTools.IMAGE_UPLOADER = imageUploader;

    editor.addEventListener('saved', function (ev) {
        var name, payload, regions, xhr;

        // Check that something changed
        regions = ev.detail().regions;
        if (Object.keys(regions).length == 0) {
            return;
        }

        // Set the editor as busy while we save our changes
        this.busy(true);

        // Collect the contents of each region into a FormData instance
        payload = new FormData();
        var arr = [];
        for (name in regions) {
            if (regions.hasOwnProperty(name)) {
                console.log("La région s'appelle : " + name + " et la valeur est : " + regions[name]);
                arr.push(JSON.stringify({
                    nomDuChamp : name,
                    valeur : regions[name]
                }));
                console.log(arr);
            }
        }

        payload.append("page", $_GET('page'));

        payload.append("data", JSON.stringify(arr));



        // Send the update content to the server to be saved
        function onStateChange(ev) {
            // Check if the request is finished
            if (ev.target.readyState == 4) {
                editor.busy(false);
                if (ev.target.status == '200') {
                    // Save was successful, notify the user with a flash
                    console.log(JSON.parse(ev.target.responseText));

                    new ContentTools.FlashUI('ok');
                } else {
                    // Save failed, notify the user with a flash
                    new ContentTools.FlashUI('no');
                }
            }
        };

        xhr = new XMLHttpRequest();
        xhr.addEventListener('readystatechange', onStateChange);
        xhr.open('POST', 'http://ctm.robinoger.com/ctm-save-post.php');
        xhr.send(payload);
    });


function imageUploader(dialog) {
    var image, xhr, xhrComplete, xhrProgress;

   // Set up the event handlers
    dialog.addEventListener('imageuploader.cancelupload', function () {
        // Cancel the current upload

        // Stop the upload
        if (xhr) {
            xhr.upload.removeEventListener('progress', xhrProgress);
            xhr.removeEventListener('readystatechange', xhrComplete);
            xhr.abort();
        }

        // Set the dialog to empty
        dialog.state('empty');
    });

    dialog.addEventListener('imageuploader.clear', function () {
        // Clear the current image
        dialog.clear();
        image = null;
    });

    dialog.addEventListener('imageuploader.fileready', function (ev) {

        // Upload a file to the server
        var formData;
        var file = ev.detail().file;

        // Define functions to handle upload progress and completion
        xhrProgress = function (ev) {
            // Set the progress for the upload
            dialog.progress((ev.loaded / ev.total) * 100);
        }

        xhrComplete = function (ev) {
            var response;

            // Check the request is complete
            if (ev.target.readyState != 4) {
                return;
            }

            // Clear the request
            xhr = null
            xhrProgress = null
            xhrComplete = null

            // Handle the result of the upload
            if (parseInt(ev.target.status) == 200) {
                // Unpack the response (from JSON)
                response = JSON.parse(ev.target.responseText);

                // Store the image details
                image = {
                    size: response.size,
                    url: response.url,
                    id: response.id
                };

                // Populate the dialog
                dialog.populate(image.url, image.size);

            } else {
                // The request failed, notify the user
                new ContentTools.FlashUI('no');
            }
        }

        // Set the dialog state to uploading and reset the progress bar to 0
        dialog.state('uploading');
        dialog.progress(0);

        // Build the form data to post to the server
        formData = new FormData();
        formData.append('image', file);
        formData.append('page',$_GET('page'));

        // Make the request
        xhr = new XMLHttpRequest();
        xhr.upload.addEventListener('progress', xhrProgress);
        xhr.addEventListener('readystatechange', xhrComplete);
        xhr.open('POST', 'http://ctm.robinoger.com/ctm-image-upload.php', true);
        xhr.send(formData);
    });

    function rotateImage(direction) {
        // Request a rotated version of the image from the server
        var formData;

        // Define a function to handle the request completion
        xhrComplete = function (ev) {
            var response;

            // Check the request is complete
            if (ev.target.readyState != 4) {
                return;
            }

            // Clear the request
            xhr = null
            xhrComplete = null

            // Free the dialog from its busy state
            dialog.busy(false);

            // Handle the result of the rotation
            if (parseInt(ev.target.status) == 200) {
                // Unpack the response (from JSON)
                response = JSON.parse(ev.target.responseText);

                // Store the image details (use fake param to force refresh)
                image = {
                    size: response.size,
                    url: response.url + '?_ignore=' + Date.now()
                };

                // Populate the dialog
                dialog.populate(image.url, image.size);

            } else {
                // The request failed, notify the user
                new ContentTools.FlashUI('no');
            }
        }

        // Set the dialog to busy while the rotate is performed
        dialog.busy(true);

        // Build the form data to post to the server
        formData = new FormData();
        formData.append('url', image.url);
        formData.append('direction', direction);

        // Make the request
        xhr = new XMLHttpRequest();
        xhr.addEventListener('readystatechange', xhrComplete);
        xhr.open('POST', '/rotate-image', true);
        xhr.send(formData);
    }
    dialog.addEventListener('imageuploader.rotateccw', function () {
        rotateImage('CCW');
    });
    dialog.addEventListener('imageuploader.rotatecw', function () {
        rotateImage('CW');
    });

    dialog.addEventListener('imageuploader.save', function () {
        var crop, cropRegion, formData;

        // Define a function to handle the request completion
        xhrComplete = function (ev) {
            // Check the request is complete
            if (ev.target.readyState !== 4) {
                return;
            }

            // Clear the request
            xhr = null
            xhrComplete = null

            // Free the dialog from its busy state
            dialog.busy(false);

            // Handle the result of the rotation
            if (parseInt(ev.target.status) === 200) {
                // Unpack the response (from JSON)
                console.log(ev.target.responseText);
                var response = JSON.parse(ev.target.responseText);
                console.log(response);

                response.size = JSON.parse("[" + response.size + "]");

                let imageSrc = response.url + '?' + Math.random();
                let focused = ContentEdit.Root.get().focused();
                let oldAttributes = {};
                for (let key in focused._attributes) {
                    oldAttributes[key] = focused._attributes[key]
                }
                delete oldAttributes['src'];
                delete oldAttributes['srcset'];


                this._dialog.save(imageSrc, response.size[0]);

                if (focused.type() === 'Image') {
                    focused.parent().detach(focused);
                    setTimeout(() => {
                        let newFocused = ContentEdit.Root.get().focused();

                        for (let key in oldAttributes) {
                            newFocused._attributes[key] = oldAttributes[key];
                        }
                        if (!oldAttributes.width) {
                            delete newFocused._attributes['width'];
                        }
                        if (!oldAttributes.height) {
                            delete newFocused._attributes['height'];
                        }
                    }, 10);
                }
                
                // Trigger the save event against the dialog with details of the
                // image to be inserted.
                dialog.save(
                    response.url,
                    response.size[0],
                    {
                        'alt': response.alt,
                        'data-ce-max-width': response.size[0][0]
                    });

            } else {
                // The request failed, notify the user
                new ContentTools.FlashUI('no');
            }
        }

        // Set the dialog to busy while the rotate is performed
        dialog.busy(true);


        // Build the form data to post to the server
        formData = new FormData();
        formData.append('img_id', image.id);

        // Set the width of the image when it's inserted, this is a default
        // the user will be able to resize the image afterwards.
        formData.append('img_max_width', 600);

        // Check if a crop region has been defined by the user
        if (dialog.cropRegion()) {
            formData.append('img_crop', dialog.cropRegion());
        }

        var alt= prompt("Quel est la description de l'image ?");
        formData.append('img_alt', alt);


        formData.append('page',$_GET('page'));



        // Make the request
        xhr = new XMLHttpRequest();
        xhr.addEventListener('readystatechange', xhrComplete);
        xhr.open('POST', 'http://ctm.robinoger.com/ctm-image-update.php', true);
        xhr.send(formData);
    });

}
});