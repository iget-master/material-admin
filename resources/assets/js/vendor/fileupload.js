(function( $ ) {
    $.fn.fileuploader = function(options) {
        
        // Default plug-in options
        var defaultOptions = {
            allowedMIME: ['image/gif',
                          'image/jpeg',
                          'image/jpg',
                          'image/pjpeg',
                          'image/x-png',
                          'image/png',
                          'application/pdf',
                          'application/msword',
                          'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                          'application/vnd.ms-excel',
                          'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ],
            allowedEXT: ['gif', 'jpeg', 'jpg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx'],
            fileContainer: "#files-list",
            fileTable: "#resource-files"
        };

        // Overrides custom options with received options
        var options = $.extend(true, defaultOptions, options);

        // Initializate the element
        this.each(function() {
            // Pass options to the element
            $(this).data('options', options);
            if($(this).is(':not(input[type="file"])')) {
                throw 'The element is not an input[type="file"]';
            } else {
                // Monitor files selection event
                $(this).on('change', function() {
                    var input = this;
                    // Instantiates a new fileHandler for each file selected
                    $.each($(this).prop('files'), function(index, file) {
                        new fileHandler(file, $(input).data('options'));
                    });
                });
            }
        }); 
    }

    var fileHandler = function(file, options) {
        this.file = file;
        this.fileName = file.name.split('.').shift();
        this.fileExtention = file.name.split('.').pop().toLowerCase();
        this.options = options;

        this.table = $(options.fileTable).data('table');
        
        // Check if file extention and MIME type are among those allowed in the options
        if (($.inArray(this.fileExtention, this.options.allowedEXT) == -1) || ($.inArray(this.file.type, this.options.allowedMIME) == -1)) {
            throw 'The file extention or MIME type are not allowed';
        } else {
            this.fileRowElement = $('#files-list .reference-line.hide').clone(true).removeClass('reference-line hide');
            this.fileRowElement.find('.file-name').text(this.file.name);
            this.fileRowElement.appendTo('#files-list');
            // Start upload
            this.uploadFile();
        }
    }

    fileHandler.prototype.uploadFile = function() {
        var self = this;
        var data = new FormData();
            data.append('file', this.file);

        var xhr = $.ajax({
                    type: 'POST',
                    url: '/file/upload',
                    data: data,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    xhr: function() {
                            var xhr = new XMLHttpRequest();
                            if(xhr.upload){
                                xhr.upload.addEventListener('progress', self.progressHandler.bind(self), false);
                            }
                            return xhr;
                        },
                    success: self.successHandler.bind(self),
                    error: self.errorHandler.bind(self),
                });

        self.fileRowElement.find('.action a').on('click', function() {
            if (xhr && xhr.readyState != 4) {
                xhr.abort();
                self.fileRowElement.remove();
            };
        });
    }

    fileHandler.prototype.progressHandler = function(e) {
        var self = this;
        if (e.lengthComputable) {
            var percent = Math.round((e.loaded / e.total) * 100);
            this.fileRowElement.find('.progress').addClass('loading').find('.progress-bar').attr('aria-valuenow', percent).width(percent + "%");
            this.fileRowElement.find('.progress .progress-bar .percentage').text(percent + "%");
        }
    };

    fileHandler.prototype.successHandler = function (data) {
        var self = this;

        var $row = this.table.createRowElement(false, data.resource_file_id, {
            'filename': this.fileName,
            'extension': ' .' + this.fileExtention,
        });

        $row.find('.action [role="download"]').attr('href', data.download_link);
        $row.find('.action [role="preview"]').attr('href', data.download_link);

        self.fileRowElement.remove();
        
    }

    fileHandler.prototype.errorHandler = function (data) {
        // @todo: Handle Errors and show feedback
    }

}( jQuery ));