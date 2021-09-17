import 'dart:io';
import 'package:path/path.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:image_picker/image_picker.dart';
import 'package:path_provider/path_provider.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';
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
        title: Text('Item Details'),
      ),
      body: Container(
        padding: EdgeInsets.all(15),
        child: Column(
          children: <Widget>[
            SizedBox(
              height: 20,
            ),
            Align(
                alignment: Alignment.center,
                child: Text(
                  'Take Photo of the Item',
                  style: TextStyle(
                      color: secondaryColor,
                      fontSize: 15,
                      fontWeight: FontWeight.w700),
                )),
            SizedBox(
              height: 10,
            ),
            Expanded(
              child: Container(
                padding: EdgeInsets.all(10),
                child: Center(
                  child: images == null
                      ? Container(
                          child: Center(
                            child: Text('Add a photo'),
                          ),
                        )
                      : Image.file(
                          images!,
                          width: MediaQuery.of(context).size.width - 15,
                          fit: BoxFit.cover,
                        ),
                ),
              ),
            ),
            SizedBox(
              height: 15,
            ),
            Center(
              child: Container(
                  height: 50,
                  width: MediaQuery.of(context).size.width - 20,
                  child: images == null
                      ? ElevatedButton(
                          style: ElevatedButton.styleFrom(
                              primary: primaryColor,
                              shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(10))),
                          onPressed: () {
                            getImage();
                          },
                          child: Text('Take Photo'),
                        )
                      : OutlineButton(
                          onPressed: () {
                            getImage();
                          },
                          child: Text('Re-take'),
                          borderSide: BorderSide(color: primaryColor),
                          shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(10)))),
            ),
            SizedBox(
              height: 15,
            ),
            Center(
              child: Container(
                height: 50,
                width: MediaQuery.of(context).size.width - 20,
                child: images == null
                    ? ElevatedButton(
                        onPressed: null,
                        child: Text('Done'),
                        style: ElevatedButton.styleFrom(
                            shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(10))),
                      )
                    : ElevatedButton(
                        style: ElevatedButton.styleFrom(
                            primary: primaryColor,
                            shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(10))),
                        onPressed: () {
                          Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => ArriveDropOff(),
                            ),
                          );
                        },
                        child: Text('Done'),
                      ),
              ),
            ),

            // Container(
            //   height: 50,
            //   width: MediaQuery.of(context).size.width - 20,
            //   child: OutlinedButton(
            //     style: OutlinedButton.styleFrom(
            //         primary: primaryColor,
            //         shape: RoundedRectangleBorder(
            //             borderRadius: BorderRadius.circular(10))),
            //     onPressed: () {
            //       getImage();
            //     },
            //     child: images == null ? Text('Take Photo') : Text('Re-take'),
            //   ),
            // ),
            SizedBox(
              height: 30,
            ),
          ],
        ),
      ),
    );
  }
}
