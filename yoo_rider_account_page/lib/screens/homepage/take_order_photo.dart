import 'dart:io';
import 'package:path/path.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:image_picker/image_picker.dart';
import 'package:path_provider/path_provider.dart';
import 'package:yoo_rider_account_page/screens/homepage/arrive_dropoff_page.dart';

class TakePhoto extends StatefulWidget {
  const TakePhoto({Key? key}) : super(key: key);

  @override
  _TakePhotoState createState() => _TakePhotoState();
}

class _TakePhotoState extends State<TakePhoto> {
  File? images;
  Future getImage() async {
    try {
      final image = await ImagePicker().getImage(
        source: ImageSource.camera,
      );
      if (image == null) return;
      // final imageFile = File(image.path);
      final imagePermanent = await saveImagePermanent(image.path);
      setState(() {
        this.images = imagePermanent;
      });
    } on PlatformException catch (e) {
      print('Failed to pick Image: $e');
    }
  }

  Future<File> saveImagePermanent(String imagePath) async {
    final directory = await getApplicationDocumentsDirectory();
    final name = basename(imagePath);
    final imageFile = File('${directory.path}/$name');
    return File(imagePath).copy(imageFile.path);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Take Photo'),
      ),
      body: Container(
        child: Column(
          children: <Widget>[
            SizedBox(
              height: MediaQuery.of(context).size.height * .2,
            ),
            Container(
              height: MediaQuery.of(context).size.height * .6,
              padding: EdgeInsets.all(10),
              child: Column(
                children: [
                  Text('Lorem Ipsum generator ksdhfgsidfg'),
                  Container(
                    height: 50,
                    child: ElevatedButton(
                      onPressed: () {
                        getImage();
                      },
                      child: Row(
                        children: [
                          Icon(Icons.camera_alt),
                          SizedBox(
                            width: 10,
                          ),
                          Text('Add Photo'),
                        ],
                      ),
                    ),
                  ),
                  SizedBox(
                    height: 20,
                  ),
                  images == null
                      ? Container(
                          height: 200,
                          child: Center(child: Text('Add a photo')))
                      : Image.file(
                          images!,
                          width: 200,
                          height: 200,
                          fit: BoxFit.cover,
                        )
                ],
              ),
            ),
            Center(
              child: Container(
                height: 50,
                width: MediaQuery.of(context).size.width - 20,
                child: ElevatedButton(
                  onPressed: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => ArriveDropOff(),
                      ),
                    );
                  },
                  child: Text('Confirm Loading'),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
