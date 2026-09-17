import 'dart:developer';

import 'package:ebroker/data/model/city_model.dart';
import 'package:ebroker/data/model/home_page_data_model.dart';
import 'package:ebroker/exports/main_export.dart';

class HomeScreenDataRepository {
  Future<({HomePageDataModel homepageDataModel})> fetchAllHomePageData() async {
    try {
      final parameters = {
        'latitude': HiveUtils.getLatitude(),
        'longitude': HiveUtils.getLongitude(),
        'radius': HiveUtils.getRadius().toString() == AppSettings.minRadius
            ? ''
            : HiveUtils.getRadius(),
      }..removeWhere((key, value) => value == '' || value == null);

      final result = await Api.get(
        url: Api.homePageData,
        queryParameters: parameters,
      );
      final data = result['data'] as Map<String, dynamic>;

      return (homepageDataModel: HomePageDataModel.fromJson(data));
    } on Exception catch (e, st) {
      log(
        e.toString(),
        stackTrace: st,
        name: 'HOME PAGE DATA ERROR:',
      );
      rethrow;
    }
  }

  Future<List<City>> fetchPropertiesByCities() async {
    try {
      final result = await Api.get(
        url: Api.apiGetPropertiesByCity,
      );

      final dynamic dataNode = result['data'];
      List<dynamic> rawList;
      if (dataNode is Map<String, dynamic> && dataNode['data'] is List) {
        rawList = dataNode['data'] as List<dynamic>;
      } else if (dataNode is List) {
        rawList = dataNode;
      } else if (result['cities'] is List) {
        rawList = result['cities'] as List<dynamic>;
      } else {
        rawList = const [];
      }

      return rawList
          .whereType<Map<dynamic, dynamic>>()
          .map((e) => City.fromMap(Map<String, dynamic>.from(e)))
          .toList();
    } on Exception catch (e, st) {
      log(
        e.toString(),
        stackTrace: st,
        name: 'PROPERTIES BY CITIES ERROR:',
      );
      rethrow;
    }
  }
}
