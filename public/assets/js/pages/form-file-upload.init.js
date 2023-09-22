
var previewTemplate,
    dropzone,
    dropzonePreviewNode = document.querySelector("#dropzone-preview-list"),
    inputMultipleElements =
        ((dropzonePreviewNode.id = ""),
            dropzonePreviewNode &&
            ((previewTemplate = dropzonePreviewNode.parentNode.innerHTML),
                dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode),
                (dropzone = new Dropzone(".dropzone", {
                    url: "../Worker/upload", method: "post", previewTemplate: previewTemplate, previewsContainer: "#dropzone-preview", init: function () {
                        this.on("success", function (file, response) {
                            Swal.fire({
                                title: "Successfull!",
                                text: "Worker records has been imported successfully.",
                                confirmButtonClass: "btn btn-primary w-xs mt-2",
                                icon: "success",
                                buttonsStyling: !1
                            }).then(function (r) {
                                window.location.href = "../Dashboard";
                            });
                        });
                    }
                }))));
