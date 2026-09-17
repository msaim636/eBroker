import 'package:ebroker/data/model/city_model.dart';
import 'package:ebroker/data/repositories/home_screen_data_repository.dart';
import 'package:ebroker/exports/main_export.dart';

abstract class FetchPropertiesByCitiesState {}

class FetchPropertiesByCitiesInitial extends FetchPropertiesByCitiesState {}

class FetchPropertiesByCitiesLoading extends FetchPropertiesByCitiesState {}

class FetchPropertiesByCitiesSuccess extends FetchPropertiesByCitiesState {
  FetchPropertiesByCitiesSuccess({required this.cities});

  final List<City> cities;

  FetchPropertiesByCitiesSuccess copyWith({
    List<City>? cities,
  }) {
    return FetchPropertiesByCitiesSuccess(
      cities: cities ?? this.cities,
    );
  }
}

class FetchPropertiesByCitiesFailure extends FetchPropertiesByCitiesState {
  FetchPropertiesByCitiesFailure(this.errorMessage);

  final dynamic errorMessage;
}

class FetchPropertiesByCitiesCubit extends Cubit<FetchPropertiesByCitiesState> {
  FetchPropertiesByCitiesCubit() : super(FetchPropertiesByCitiesInitial());

  final HomeScreenDataRepository _repository = HomeScreenDataRepository();

  Future<void> fetch() async {
    try {
      if (state is FetchPropertiesByCitiesSuccess) {
        emit(
          (state as FetchPropertiesByCitiesSuccess).copyWith(
            cities: (state as FetchPropertiesByCitiesSuccess).cities,
          ),
        );
      } else {
        emit(FetchPropertiesByCitiesLoading());
      }
      final cities = await _repository.fetchPropertiesByCities();
      emit(FetchPropertiesByCitiesSuccess(cities: cities));
    } on Exception catch (e) {
      emit(FetchPropertiesByCitiesFailure(e));
    }
  }
}
