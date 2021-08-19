import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

class ProfileSecurityBody extends StatefulWidget {
  @override
  State<ProfileSecurityBody> createState() => _ProfileSecurityBodyState();
}

class _ProfileSecurityBodyState extends State<ProfileSecurityBody> {
  late PickedFile _imageFile;
  final ImagePicker _picker = ImagePicker();

  void takePhoto(ImageSource source) async {
    final pickedFile = await _picker.getImage(
      source: source,
    );
    setState(() {
      _imageFile = pickedFile!;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: EdgeInsets.all(10),
      child: ListView(
        children: <Widget>[
          SafeArea(
            child: Center(
              child: Column(
                children: [
                  SizedBox(
                    height: 20,
                  ),
                  profileavatar(context)
                ],
              ),
            ),
          ),
          SizedBox(
            height: 20,
          ),
          SafeArea(
            child: Column(
              children: [
                editname(),
                editcontact(),
                editemail(),
              ],
            ),
          ),
          Container(
            margin: EdgeInsets.all(20),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.end,
              children: [
                saveButton(),
              ],
            ),
          ),
          Divider(),
          SafeArea(
            child: Column(
              children: [
                passwordchange(),
                language(),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget profileavatar(BuildContext context) {
    return SizedBox(
      height: 100,
      width: 100,
      child: Stack(
        fit: StackFit.expand,
        overflow: Overflow.visible,
        children: [
          CircleAvatar(
              backgroundColor: Colors.white.withOpacity(.2),
              backgroundImage: //_imageFile == null ?
                  AssetImage("assets/user_picture.png")
              // : FileImage(
              //     File(_imageFile.path),
              //   ),
              ),
          Positioned(
            right: -3,
            bottom: -3,
            child: SizedBox(
              height: 46,
              width: 46,
              child: InkWell(
                onTap: () {
                  showModalBottomSheet(
                      context: context, builder: (builder) => bottomSheet());
                },
                child: Icon(
                  Icons.camera_alt,
                  color: Colors.teal,
                ),
              ),
            ),
          )
        ],
      ),
    );
  }

//ModalBottomSheetNavigation
  Widget bottomSheet() {
    return Container(
      height: 100,
      margin: EdgeInsets.symmetric(
        horizontal: 20,
        vertical: 20,
      ),
      child: Column(
        children: <Widget>[
          Text(
            "Choose Profile Photo",
            style: TextStyle(
              fontSize: 20,
            ),
          ),
          SizedBox(
            height: 20,
          ),
          Center(
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: <Widget>[
                FloatingActionButton.extended(
                  onPressed: () {
                    takePhoto(ImageSource.camera);
                  },
                  label: Text("Camera"),
                  icon: Icon(Icons.camera),
                ),
                FloatingActionButton.extended(
                  onPressed: () {
                    takePhoto(ImageSource.gallery);
                  },
                  label: Text("Gallery"),
                  icon: Icon(Icons.image),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget editname() {
    return ListTile(
      leading: Icon(Icons.person),
      title: Text('Rider Juan dela Cruz'),
    );
  }

  Widget editcontact() {
    return ListTile(
      leading: Icon(Icons.phone),
      title: Text('0928476982'),
    );
  }

  Widget editemail() {
    return ListTile(
      leading: Icon(Icons.email),
      title: TextFormField(
        decoration: InputDecoration.collapsed(
          hintText: 'Email Address',
          hintStyle: TextStyle(fontSize: 15),
        ),
      ),
    );
  }

  Widget saveButton() {
    return RaisedButton(
      onPressed: () {},
      child: Text('SAVE'),
      padding: EdgeInsets.all(10),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(20),
      ),
    );
  }

  Widget passwordchange() {
    return Container(
      padding: EdgeInsets.only(
        left: 20,
        right: 20,
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            'Change Password',
            style: TextStyle(fontSize: 15, fontWeight: FontWeight.w500),
          ),
          IconButton(
            onPressed: () {},
            icon: Icon(Icons.arrow_forward_ios_outlined),
          ),
        ],
      ),
    );
  }

  Widget language() {
    return Container(
      padding: EdgeInsets.only(
        left: 20,
        right: 20,
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            'Language',
            style: TextStyle(fontSize: 15, fontWeight: FontWeight.w500),
          ),
          IconButton(
            onPressed: () {},
            icon: Icon(Icons.arrow_forward_ios_outlined),
          ),
        ],
      ),
    );
  }
}
