import 'package:ebroker/utils/Extensions/extensions.dart';
import 'package:ebroker/utils/app_icons.dart';
import 'package:ebroker/utils/custom_image.dart';
import 'package:ebroker/utils/custom_text.dart';
import 'package:ebroker/utils/responsive_size.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';

class SomethingWentWrong extends StatelessWidget {
  const SomethingWentWrong({required this.errorMessage, super.key});
  final String errorMessage;

  static void asGlobalErrorBuilder() {
    if (kReleaseMode) {
      ErrorWidget.builder = (FlutterErrorDetails flutterErrorDetails) =>
          SomethingWentWrong(
            errorMessage: flutterErrorDetails.toString(),
          );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        CustomImage(
          imageUrl: AppIcons.somethingWentWrong,
          fit: BoxFit.contain,
          width: 280.rw(context),
        ),
        SizedBox(
          height: 12.rh(context),
        ),
        CustomText(
          errorMessage.translate(context),
          textAlign: TextAlign.center,
          fontWeight: FontWeight.bold,
          fontSize: context.font.lg,
        ),
      ],
    );
  }
}
