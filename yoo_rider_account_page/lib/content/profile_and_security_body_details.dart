import 'dart:convert';
import 'dart:io';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:http/http.dart';
import 'package:image_picker/image_picker.dart';
import 'package:path_provider/path_provider.dart';
import 'package:path/path.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/models/rider_login_model.dart';
import 'package:yoo_rider_account_page/models/sample_user_rider_model.dart';
import 'package:yoo_rider_account_page/services/rider_login_api_service.dart';
import 'package:yoo_rider_account_page/widgets/profile_widgets.dart';

class ProfileSecurityBody extends StatefulWidget {
  @override
  State<ProfileSecurityBody> createState() => _ProfileSecurityBodyState();
}

class _ProfileSecurityBodyState extends State<ProfileSecurityBody> {
  // User user = UserPreferences.myUser;
  late User user;

  @override
  void initState() {
    super.initState();
    user = UserPreferences.getUser();
  }

  Future takePhoto(ImageSource source) async {
    final image = await ImagePicker().getImage(
      source: source,
    );

    if (image == null) return;
    final directory = await getApplicationDocumentsDirectory();
    final name = basename(image.path);
    final imageFile = File('${directory.path}/$name');
    final newImage = await File(image.path).copy(imageFile.path);

    setState(() => user = user.copy(defaultImage: newImage.path));
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
                  ProfileWidget(
                      isEdit: true,
                      defaultImage: user.defaultImage,
                      onClicked: () {
                        //ModalBottomSheet
                        showModalBottomSheet(
                          context: context,
                          builder: (context) => Container(
                            height: MediaQuery.of(context).size.height * 0.16,
                            child: Column(
                              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                              children: <Widget>[
                                ListTile(
                                  leading: Icon(Icons.camera),
                                  title: Text('Camera'),
                                  onTap: () {
                                    takePhoto(ImageSource.camera);
                                  },
                                ),
                                ListTile(
                                  leading: Icon(Icons.image),
                                  title: Text('Gallery'),
                                  onTap: () {
                                    takePhoto(ImageSource.gallery);
                                  },
                                )
                              ],
                            ),
                          ),
                        );
                      }),
                  SizedBox(
                    height: 20,
                  ),
                  ProfileTextField(
                    label: 'Full Name',
                    text: user.userName,
                    onChanged: (userName) =>
                        user = user.copy(userName: userName),
                  ),
                  SizedBox(
                    height: 10,
                  ),
                  ProfileTextField(
                    label: 'Contact Number',
                    text: user.number,
                    onChanged: (number) => user = user.copy(number: number),
                  ),
                  SizedBox(
                    height: 10,
                  ),
                  ProfileTextField(
                    label: 'Email Address',
                    text: user.email,
                    onChanged: (email) => user = user.copy(email: email),
                  ),
                  Container(
                    margin: EdgeInsets.all(20),
                    child: RaisedButton(
                      onPressed: () {
                        UserPreferences.setUser(user);
                        Navigator.of(context).pop();
                        print(user.userName);
                        print(user.number);
                        print(user.email);
                      },
                      child: Text('SAVE'),
                      padding: EdgeInsets.all(10),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(20),
                      ),
                    ),
                  ),
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
            ),
          ),
        ],
      ),
    );
  }

  Widget passwordchange() {
    return ListTile(
      title: Text('Change Password'),
      trailing: Icon(Icons.arrow_forward_ios_outlined),
      onTap: () {},
    );
  }

  Widget language() {
    return ListTile(
      title: Text('Language'),
      trailing: Icon(Icons.arrow_forward_ios_outlined),
      onTap: () {},
    );
  }
}
