## CodeLib Sample: Form Upload 1

### Description

This sample illustrates how to configure your Application to handle file uploads in a different way than the sample formupload1.
Instead of using auto configuration, here we explicitly tell CL where we would like to store our uploaded files. This is done with the following configuration entry:

#### ->addAppConfig(UPLOAD_CONFIG, [UPLOAD_DIR => BASE_DIR.'/resources/alt_uploads']);

The above will tell Code-lib to use the path **resources/alt_uploads** as our folder to store uploaded files. 
If it doesn't exist, it will be created, relative to your App root, when the App runs. 

### Running this Sample

- Access this sample **index.php** file via your webserver
- You will see a form you can use to upload up to 2 files
- Select the files you want to upload and press submit

