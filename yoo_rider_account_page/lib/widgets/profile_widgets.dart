import 'dart:io';
import 'dart:ui';

import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:image_picker/image_picker.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';

class ProfileTextField extends StatefulWidget {
  final int maxLines;
  final String label;
  final String text;
  final ValueChanged<String> onChanged;

  const ProfileTextField(
      {Key? key,
      this.maxLines = 1,
      required this.label,
      required this.text,
      required this.onChanged})
      : super(key: key);

  @override
  _ProfileTextFieldState createState() => _ProfileTextFieldState();
}

class _ProfileTextFieldState extends State<ProfileTextField> {
  late final TextEditingController controller;

  final user = UserPreferences.getUser();

  @override
  void initState() {
    super.initState();
    controller = TextEditingController(text: widget.text);
  }

  @override
  void dispose() {
    controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          widget.label,
          style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
        ),
        SizedBox(
          height: 8,
        ),
        Container(
          height: 50,
          child: TextField(
            maxLines: widget.maxLines,
            onChanged: widget.onChanged,
            controller: controller,
            decoration: InputDecoration(
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(10),
              ),
            ),
          ),
        )
      ],
    );
  }
}

class ProfileWidget extends StatefulWidget {
  final bool isEdit;
  final String defaultImage;
  final VoidCallback onClicked;
  const ProfileWidget(
      {Key? key,
      this.isEdit = false,
      required this.defaultImage,
      required this.onClicked})
      : super(key: key);

  @override
  State<ProfileWidget> createState() => _ProfileWidgetState();
}

class _ProfileWidgetState extends State<ProfileWidget> {
  // File? image;
  // PickedFile? _imageFile;
  // Future takePhoto(ImageSource source) async {
  //   try {
  //     final pickedFile = await ImagePicker().getImage(
  //       source: source,
  //     );

  //     if (pickedFile == null) return;

  //     final _imageFile = File(pickedFile.path);
  //     // final imagePermanent = await savePermanently(pickedFile.path);
  //     setState(() {
  //       // this.image = imagePermanent;
  //       this.image = _imageFile;
  //     });
  //   } on PlatformException catch (e) {
  //     print('Failed to pick an image: $e');
  //   }
  // }

  @override
  Widget build(BuildContext context) {
    final color = Theme.of(context).primaryColor;
    return Center(
      child: Stack(
        children: [
          buildImage(),
          Positioned(
            bottom: 7,
            right: 10,
            child: buildEditIcon(color, context),
          ),
        ],
      ),
    );
  }

  Widget buildImage() {
    final defImage = widget.defaultImage.contains('assets/')
        ? AssetImage('${widget.defaultImage}')
        : FileImage(File(widget.defaultImage));
    return ClipOval(
      child: Material(
        color: Colors.transparent,
        child: Ink.image(
          image: defImage as ImageProvider,
          fit: BoxFit.cover,
          width: 128,
          height: 128,
          child: InkWell(
            onTap: widget.onClicked,
          ),
        ),
      ),
    );
  }

  Widget buildEditIcon(Color color, BuildContext context) => buildCircle(
        color: Colors.white,
        all: 2,
        child: buildCircle(
          color: color,
          all: 6,
          child: InkWell(
            onTap: () {
              // showModalBottomSheet(
              //     context: context, builder: (builder) => bottomSheet(context));
            },
            child: Icon(
              widget.isEdit ? Icons.add_a_photo : Icons.edit,
              color: Colors.white,
              size: 18,
            ),
          ),
        ),
      );

  Widget buildCircle({
    required Widget child,
    required double all,
    required Color color,
  }) =>
      ClipOval(
        child: Container(
          padding: EdgeInsets.all(all),
          child: child,
          color: color,
        ),
      );
}
