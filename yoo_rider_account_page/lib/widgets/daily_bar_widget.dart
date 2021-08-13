import 'package:fl_chart/fl_chart.dart';
import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/widgets/daily_bar_data.dart';

class DailyBarChart extends StatelessWidget {
  final double barWidth = 22;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: BoxDecoration(
          color: Colors.orange,
        ),
        child: Padding(
          padding: EdgeInsets.only(top: 16),
          child: Container(
            child: Padding(
              padding: const EdgeInsets.all(8.0),
              child: BarChart(
                BarChartData(
                  alignment: BarChartAlignment.center,
                  maxY: 20,
                  groupsSpace: 12,
                  barTouchData: BarTouchData(enabled: true),
                  titlesData: FlTitlesData(
                    bottomTitles: BarTitles.getTopBottomTitles(),
                    leftTitles: BarTitles.getSideTitles(),
                  ),
                  barGroups: BarData.barData
                      .map(
                        (data) => BarChartGroupData(x: data.id, barRods: [
                          BarChartRodData(
                              y: data.y,
                              width: barWidth,
                              colors: [data.color],
                              borderRadius: BorderRadius.only(
                                topLeft: Radius.circular(6),
                                topRight: Radius.circular(6),
                              )),
                        ]),
                      )
                      .toList(),
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }
}

class BarTitles {
  static SideTitles getTopBottomTitles() => SideTitles(
        showTitles: true,
        getTextStyles: (value) => const TextStyle(
          color: Colors.black,
          fontSize: 10,
        ),
        margin: 10,
        getTitles: (double id) => BarData.barData
            .firstWhere((element) => element.id == id.toInt())
            .name,
      );

  static SideTitles getSideTitles() => SideTitles(
        showTitles: true,
        getTextStyles: (value) => const TextStyle(
          color: Colors.black,
          fontSize: 10,
        ),
        interval: BarData.interval.toDouble(),
        margin: 10,
        getTitles: (double value) => '${value.toInt()}k',
      );
}
