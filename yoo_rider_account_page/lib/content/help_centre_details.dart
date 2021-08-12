import 'package:flutter/material.dart';

class HelpCentreDetails extends StatelessWidget {
  const HelpCentreDetails({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Container(
          margin: EdgeInsets.all(10),
          child: Column(
            children: <Widget>[
              Container(
                child: ExpansionTile(
                  leading: CircleAvatar(
                    radius: 30,
                    child: Icon(Icons.question_answer_outlined),
                  ),
                  title: Text(
                    'Frequently Asked Questions',
                    style: TextStyle(fontWeight: FontWeight.w500),
                  ),
                  children: [
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Container(
                          width: MediaQuery.of(context).size.width * .42,
                          child: RaisedButton(
                            onPressed: () {},
                            child: Text('Personal'),
                          ),
                        ),
                        SizedBox(
                          width: 10,
                        ),
                        Container(
                          width: MediaQuery.of(context).size.width * .42,
                          child: RaisedButton(
                            onPressed: () {},
                            child: Text('Driver'),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
              SizedBox(
                height: 10,
              ),
            ],
          ),
        ),
        Expanded(
          child: SingleChildScrollView(
            child: Column(
              children: [
                ExpansionTile(
                  title: Text('Lorem ipsum dolor sit amet??'),
                  children: [
                    Container(
                      margin: EdgeInsets.all(20),
                      child: Text(
                          'Answer 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sit amet vehicula dui, quis tempus lectus. Aenean vel lobortis leo. Nunc at felis at sem varius pharetra. Donec egestas lacus nunc, a vehicula lacus sodales ut. Pellentesque et ultricies nunc. Duis iaculis dui id risus tincidunt, vel tristique mi condimentum. Cras maximus quam quis dolor placerat, ac bibendum sapien venenatis. Cras congue ullamcorper dui, sit amet ullamcorper nisi viverra a.'),
                    ),
                  ],
                ),
                ExpansionTile(
                  title: Text('Vivamus condimentum efficitur sem??'),
                  children: [
                    Container(
                      margin: EdgeInsets.all(20),
                      child: Text(
                          'Answer 2: Vivamus condimentum efficitur sem, id dapibus felis. Integer nisl orci, maximus non dignissim at, imperdiet vitae arcu. Morbi erat turpis, hendrerit ac elit at, auctor blandit mauris. Nam cursus, enim in sagittis ultrices, nibh ipsum porta arcu, eget maximus ipsum ex et mi. Phasellus dapibus nisi ac odio varius, sit amet ullamcorper enim ultrices. Cras sed lectus ante.'),
                    ),
                  ],
                ),
                ExpansionTile(
                  title: Text('Duis eleifend dapibus sapien ut commodo??'),
                  children: [
                    Container(
                      margin: EdgeInsets.all(20),
                      child: Text(
                          'Answer 2: Duis eleifend dapibus sapien ut commodo. Pellentesque suscipit dolor a lacinia semper. Phasellus ultrices, nunc a semper placerat, nibh ante iaculis ante, quis elementum ipsum mi quis metus. Nulla magna tellus, mollis sed risus vel, dapibus ornare velit. In hac habitasse platea dictumst. Fusce in arcu nisl. Sed eleifend sollicitudin tellus quis commodo.'),
                    ),
                  ],
                ),
                Container(
                  margin: EdgeInsets.all(10),
                  child: ListTile(
                    leading: CircleAvatar(
                      radius: 20,
                      child: Icon(Icons.message),
                    ),
                    title: Text(
                      'Chat Support',
                      style: TextStyle(fontWeight: FontWeight.w400),
                    ),
                    onTap: () {},
                  ),
                )
              ],
            ),
          ),
        ),
      ],
    );
  }
}

// Widget _personal(BuildContext context) {
//   return Expanded(
//     child: SingleChildScrollView(
//       child: Column(
//         children: [
//           ExpansionTile(
//             title: Text('Lorem ipsum dolor sit amet??'),
//             children: [
//               Container(
//                 margin: EdgeInsets.all(20),
//                 child: Text(
//                     'Answer 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sit amet vehicula dui, quis tempus lectus. Aenean vel lobortis leo. Nunc at felis at sem varius pharetra. Donec egestas lacus nunc, a vehicula lacus sodales ut. Pellentesque et ultricies nunc. Duis iaculis dui id risus tincidunt, vel tristique mi condimentum. Cras maximus quam quis dolor placerat, ac bibendum sapien venenatis. Cras congue ullamcorper dui, sit amet ullamcorper nisi viverra a.'),
//               ),
//             ],
//           ),
//           ExpansionTile(
//             title: Text('Vivamus condimentum efficitur sem??'),
//             children: [
//               Container(
//                 margin: EdgeInsets.all(20),
//                 child: Text(
//                     'Answer 2: Vivamus condimentum efficitur sem, id dapibus felis. Integer nisl orci, maximus non dignissim at, imperdiet vitae arcu. Morbi erat turpis, hendrerit ac elit at, auctor blandit mauris. Nam cursus, enim in sagittis ultrices, nibh ipsum porta arcu, eget maximus ipsum ex et mi. Phasellus dapibus nisi ac odio varius, sit amet ullamcorper enim ultrices. Cras sed lectus ante.'),
//               ),
//             ],
//           ),
//           ExpansionTile(
//             title: Text('Duis eleifend dapibus sapien ut commodo??'),
//             children: [
//               Container(
//                 margin: EdgeInsets.all(20),
//                 child: Text(
//                     'Answer 2: Duis eleifend dapibus sapien ut commodo. Pellentesque suscipit dolor a lacinia semper. Phasellus ultrices, nunc a semper placerat, nibh ante iaculis ante, quis elementum ipsum mi quis metus. Nulla magna tellus, mollis sed risus vel, dapibus ornare velit. In hac habitasse platea dictumst. Fusce in arcu nisl. Sed eleifend sollicitudin tellus quis commodo.'),
//               ),
//             ],
//           ),
//           Container(
//             margin: EdgeInsets.all(10),
//             child: ListTile(
//               leading: CircleAvatar(
//                 radius: 20,
//                 child: Icon(Icons.message),
//               ),
//               title: Text(
//                 'Chat Support',
//                 style: TextStyle(fontWeight: FontWeight.w400),
//               ),
//               onTap: () {},
//             ),
//           )
//         ],
//       ),
//     ),
//   );
// }
