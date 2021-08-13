import 'package:flutter/material.dart';

class OrderPage extends StatefulWidget {
  @override
  _OrderPageState createState() => _OrderPageState();
}

class _OrderPageState extends State<OrderPage> {
  @override
  Widget build(BuildContext context) {
    return DefaultTabController(
      length: 3,
      child: Scaffold(
        appBar: AppBar(
          title: Text('My Order'),
          bottom: TabBar(
            tabs: <Widget>[
              Tab(text: "Ongoing"),
              Tab(text: "Completed"),
              Tab(text: "Cancelled"),
            ],
          ),
        ),
        body: TabBarView(
          children: <Widget>[
            _buildListViewWithName('Ongoing'),
            _buildListViewWithName('Completed'),
            _buildListViewWithName('Cancelled'),
          ],
        ),
      ),
    );
  }

  ListView _buildListViewWithName(String s) {
    return ListView.builder(
        itemBuilder: (context, index) => ListTile(
              title: Text(s + '$index'),
            ));
  }
}
