## CodeLib Sample: Form Upload 1

### Description

This sample illustrates how to configure your Application to handle file uploads.
In its simplest form, all that is required is to add the following configuration entry:

#### $clconfig->addAppConfig(UPLOAD_CONFIG, [UPLOAD_AUTOCONFIG => true]);

The above will tell Code-lib to auto-configure file uploads, which will result in the creation of the **resources/uploads** path 
relative to your App root. This path will then be used to store files submitted with any form.

### Running this Sample

- Access this sample **index.php** file via your webserver
- You will see a form you can use to upload up to 2 files
- Select the files you want to upload and press submit

