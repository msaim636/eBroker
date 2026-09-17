import 'package:ebroker/data/cubits/appointment/get/fetch_agent_previous_appointments_cubit.dart';
import 'package:ebroker/data/cubits/appointment/get/fetch_agent_upcoming_appointments_cubit.dart';
import 'package:ebroker/data/cubits/appointment/get/fetch_user_previous_appointments_cubit.dart';
import 'package:ebroker/data/cubits/appointment/get/fetch_user_upcoming_appointments_cubit.dart';
import 'package:ebroker/data/cubits/appointment/post/create_appointment_request_cubit.dart';
import 'package:ebroker/data/cubits/appointment/post/update_appointment_status_cubit.dart';
import 'package:ebroker/data/cubits/appointment/post/update_meeting_type_cubit.dart';
import 'package:ebroker/data/model/appointment/appointment_model.dart';
import 'package:ebroker/exports/main_export.dart';
import 'package:ebroker/ui/screens/appointment/appointment_helpers/appointment_card.dart';
import 'package:ebroker/ui/screens/home/widgets/custom_refresh_indicator.dart';
import 'package:ebroker/utils/custom_tabbar.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

class MyAppointmentsScreen extends StatefulWidget {
  const MyAppointmentsScreen({
    required this.isAgent,
    super.key,
  });
  final bool isAgent;

  static Route<dynamic> route(RouteSettings routeSettings) {
    final args = routeSettings.arguments as Map<String, dynamic>? ?? {};
    final isAgent = args['isAgent'] as bool? ?? false;
    return CupertinoPageRoute(
      builder: (context) => MyAppointmentsScreen(isAgent: isAgent),
    );
  }

  @override
  State<MyAppointmentsScreen> createState() => _MyAppointmentsScreenState();
}

class _MyAppointmentsScreenState extends State<MyAppointmentsScreen>
    with TickerProviderStateMixin {
  late TabController _tabController;
  late List<ScrollController> _scrollControllers;

  // Track which tabs have been loaded
  final List<bool> _tabsLoaded = [false, false];

  static const int _upcomingTabIndex = 0;
  static const int _previousTabIndex = 1;

  // Date grouping helper methods
  Map<String, List<AppointmentModel>> _groupAppointmentsByDate(
    List<AppointmentModel> appointments,
  ) {
    final groupedAppointments = <String, List<AppointmentModel>>{};

    for (final appointment in appointments) {
      final dateKey = _getDateKey(appointment);
      if (groupedAppointments.containsKey(dateKey)) {
        groupedAppointments[dateKey]!.add(appointment);
      } else {
        groupedAppointments[dateKey] = [appointment];
      }
    }

    // Sort appointments within each date group by start time
    groupedAppointments.forEach((dateKey, appointments) {
      appointments.sort((a, b) => a.startAt.compareTo(b.startAt));
    });

    return groupedAppointments;
  }

  String _getDateKey(AppointmentModel appointment) {
    try {
      // Use startAt parameter to get the date
      final date = DateTime.parse(appointment.startAt);
      return DateFormat('yyyy-MM-dd').format(date);
    } on Exception {
      // Fallback to a default date if parsing fails
      return DateFormat('yyyy-MM-dd').format(DateTime.now());
    }
  }

  String _formatDateHeader(String dateKey) {
    try {
      return dateKey.formatDate(format: 'MMM d, yyyy');
    } on Exception {
      return dateKey;
    }
  }

  @override
  void initState() {
    super.initState();
    _initializeControllers();
    _loadInitialData();
  }

  void _initializeControllers() {
    _tabController = TabController(length: 2, vsync: this);
    _tabController.addListener(_handleTabChange);

    _scrollControllers = List.generate(2, (_) => ScrollController());

    for (var i = 0; i < _scrollControllers.length; i++) {
      _scrollControllers[i].addListener(() => _handleScroll(i));
    }
  }

  void _loadInitialData() {
    _fetchAppointments(_upcomingTabIndex, forceRefresh: true);
    _tabsLoaded[_upcomingTabIndex] = true;
  }

  @override
  void dispose() {
    for (final controller in _scrollControllers) {
      controller.dispose();
    }
    _tabController.dispose();
    super.dispose();
  }

  void _handleTabChange() {
    setState(() {});
    final currentIndex = _tabController.index;

    if (!_tabsLoaded[currentIndex] || _shouldRefetch(currentIndex)) {
      _fetchAppointments(currentIndex, forceRefresh: true);
      _tabsLoaded[currentIndex] = true;
    }
  }

  void _handleScroll(int tabIndex) {
    if (_scrollControllers[tabIndex].isEndReached() && _hasMoreData(tabIndex)) {
      _fetchMoreData(tabIndex);
    }
  }

  // Unified appointment fetching logic
  void _fetchAppointments(int tabIndex, {bool forceRefresh = false}) {
    final isUpcoming = tabIndex == _upcomingTabIndex;

    if (widget.isAgent) {
      if (isUpcoming) {
        context
            .read<FetchAgentUpcomingAppointmentsCubit>()
            .fetchAgentUpcomingAppointments(forceRefresh: forceRefresh);
      } else {
        context
            .read<FetchAgentPreviousAppointmentsCubit>()
            .fetchAgentPreviousAppointments(forceRefresh: forceRefresh);
      }
    } else {
      if (isUpcoming) {
        context
            .read<FetchUserUpcomingAppointmentsCubit>()
            .fetchUserUpcomingAppointments(forceRefresh: forceRefresh);
      } else {
        context
            .read<FetchUserPreviousAppointmentsCubit>()
            .fetchUserPreviousAppointments(forceRefresh: forceRefresh);
      }
    }
  }

  void _fetchMoreData(int tabIndex) {
    final isUpcoming = tabIndex == _upcomingTabIndex;

    if (widget.isAgent) {
      if (isUpcoming) {
        context.read<FetchAgentUpcomingAppointmentsCubit>().fetchMore();
      } else {
        context.read<FetchAgentPreviousAppointmentsCubit>().fetchMore();
      }
    } else {
      if (isUpcoming) {
        context.read<FetchUserUpcomingAppointmentsCubit>().fetchMore();
      } else {
        context.read<FetchUserPreviousAppointmentsCubit>().fetchMore();
      }
    }
  }

  bool _hasMoreData(int tabIndex) {
    final isUpcoming = tabIndex == _upcomingTabIndex;

    if (widget.isAgent) {
      return isUpcoming
          ? context.read<FetchAgentUpcomingAppointmentsCubit>().hasMoreData()
          : context.read<FetchAgentPreviousAppointmentsCubit>().hasMoreData();
    } else {
      return isUpcoming
          ? context.read<FetchUserUpcomingAppointmentsCubit>().hasMoreData()
          : context.read<FetchUserPreviousAppointmentsCubit>().hasMoreData();
    }
  }

  bool _shouldRefetch(int tabIndex) {
    final isUpcoming = tabIndex == _upcomingTabIndex;

    if (widget.isAgent) {
      if (isUpcoming) {
        final state = context.read<FetchAgentUpcomingAppointmentsCubit>().state;
        return state is! FetchAgentUpcomingAppointmentsSuccess;
      } else {
        final state = context.read<FetchAgentPreviousAppointmentsCubit>().state;
        return state is! FetchAgentPreviousAppointmentsSuccess;
      }
    } else {
      if (isUpcoming) {
        final state = context.read<FetchUserUpcomingAppointmentsCubit>().state;
        return state is! FetchUserUpcomingAppointmentsSuccess;
      } else {
        final state = context.read<FetchUserPreviousAppointmentsCubit>().state;
        return state is! FetchUserPreviousAppointmentsSuccess;
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return MultiBlocListener(
      listeners: [
        BlocListener<
          CreateAppointmentRequestCubit,
          CreateAppointmentRequestState
        >(
          listener: (context, state) {
            if (state is CreateAppointmentRequestSuccess) {
              HelperUtils.showSnackBarMessage(
                context,
                'appointmentScheduledSuccessfully',
                type: MessageType.success,
              );
            }
            if (state is CreateAppointmentRequestFailure) {
              HelperUtils.showSnackBarMessage(
                context,
                state.errorMessage,
                type: MessageType.error,
              );
            }
          },
        ),
        BlocListener<UpdateMeetingTypeCubit, UpdateMeetingTypeState>(
          listener: (context, state) {
            if (state is UpdateMeetingTypeSuccess) {
              HelperUtils.showSnackBarMessage(
                context,
                'meetingTypeUpdatedSuccessfully',
                type: MessageType.success,
              );
            }
            if (state is UpdateMeetingTypeFailure) {
              HelperUtils.showSnackBarMessage(
                context,
                state.errorMessage,
                type: MessageType.error,
              );
            }
          },
        ),
        BlocListener<
          UpdateAppointmentStatusCubit,
          UpdateAppointmentStatusState
        >(
          listener: (context, state) {
            if (state is UpdateAppointmentStatusSuccess) {
              HelperUtils.showSnackBarMessage(
                context,
                'appointmentStatusUpdatedSuccessfully',
                type: MessageType.success,
              );
            }
            if (state is UpdateAppointmentStatusFailure) {
              HelperUtils.showSnackBarMessage(
                context,
                state.errorMessage,
                type: MessageType.error,
              );
            }
          },
        ),
      ],
      child: Scaffold(
        backgroundColor: context.color.backgroundColor,
        appBar: CustomAppBar(title: 'myAppointments'.translate(context)),
        body: Column(
          children: [
            _buildTabBar(),
            Expanded(
              child: TabBarView(
                controller: _tabController,
                physics: const NeverScrollableScrollPhysics(),
                children: [
                  _buildTabContent(_upcomingTabIndex),
                  _buildTabContent(_previousTabIndex),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildTabBar() {
    return CustomTabBar(
      tabController: _tabController,
      isScrollable: false,
      tabs: [
        Tab(text: 'upComing'.translate(context)),
        Tab(text: 'previous'.translate(context)),
      ],
    );
  }

  Widget _buildTabContent(int tabIndex) {
    return CustomRefreshIndicator(
      onRefresh: () async {
        await _refreshTab(tabIndex);
      },
      child: _buildAppointmentsList(tabIndex),
    );
  }

  Future<void> _refreshTab(int tabIndex) async {
    _fetchAppointments(tabIndex, forceRefresh: true);
    _tabsLoaded[tabIndex] = true;
  }

  Widget _buildAppointmentsList(int tabIndex) {
    final isUpcoming = tabIndex == _upcomingTabIndex;

    if (widget.isAgent) {
      return isUpcoming ? _buildAgentUpcomingList() : _buildAgentPreviousList();
    } else {
      return isUpcoming ? _buildUserUpcomingList() : _buildUserPreviousList();
    }
  }

  Widget _buildUserUpcomingList() {
    return BlocBuilder<
      FetchUserUpcomingAppointmentsCubit,
      FetchUserUpcomingAppointmentsState
    >(
      builder: (context, state) => _buildAppointmentsListContent(
        state: state,
        appointments: state is FetchUserUpcomingAppointmentsSuccess
            ? state.appointments
            : [],
        isLoadingMore:
            state is FetchUserUpcomingAppointmentsSuccess &&
            state.isLoadingMore,
        onRetry: () =>
            _fetchAppointments(_upcomingTabIndex, forceRefresh: true),
        scrollController: _scrollControllers[_upcomingTabIndex],
        isUpcoming: true,
        emptyDescription: 'noUpcomingAppointments'.translate(context),
      ),
    );
  }

  Widget _buildUserPreviousList() {
    return BlocBuilder<
      FetchUserPreviousAppointmentsCubit,
      FetchUserPreviousAppointmentsState
    >(
      builder: (context, state) => _buildAppointmentsListContent(
        state: state,
        appointments: state is FetchUserPreviousAppointmentsSuccess
            ? state.appointments
            : [],
        isLoadingMore:
            state is FetchUserPreviousAppointmentsSuccess &&
            state.isLoadingMore,
        onRetry: () =>
            _fetchAppointments(_previousTabIndex, forceRefresh: true),
        scrollController: _scrollControllers[_previousTabIndex],
        isUpcoming: false,
        emptyDescription: 'noPreviousAppointments'.translate(context),
      ),
    );
  }

  Widget _buildAgentUpcomingList() {
    return BlocBuilder<
      FetchAgentUpcomingAppointmentsCubit,
      FetchAgentUpcomingAppointmentsState
    >(
      builder: (context, state) => _buildAppointmentsListContent(
        state: state,
        appointments: state is FetchAgentUpcomingAppointmentsSuccess
            ? state.appointments
            : [],
        isLoadingMore:
            state is FetchAgentUpcomingAppointmentsSuccess &&
            state.isLoadingMore,
        onRetry: () =>
            _fetchAppointments(_upcomingTabIndex, forceRefresh: true),
        scrollController: _scrollControllers[_upcomingTabIndex],
        isUpcoming: true,
        emptyDescription: 'noUpcomingAppointments'.translate(context),
      ),
    );
  }

  Widget _buildAgentPreviousList() {
    return BlocBuilder<
      FetchAgentPreviousAppointmentsCubit,
      FetchAgentPreviousAppointmentsState
    >(
      builder: (context, state) => _buildAppointmentsListContent(
        state: state,
        appointments: state is FetchAgentPreviousAppointmentsSuccess
            ? state.appointments
            : [],
        isLoadingMore:
            state is FetchAgentPreviousAppointmentsSuccess &&
            state.isLoadingMore,
        onRetry: () =>
            _fetchAppointments(_previousTabIndex, forceRefresh: true),
        scrollController: _scrollControllers[_previousTabIndex],
        isUpcoming: false,
        emptyDescription: 'noPreviousAppointments'.translate(context),
      ),
    );
  }

  Widget _buildAppointmentsListContent({
    required dynamic state,
    required List<AppointmentModel> appointments,
    required bool isLoadingMore,
    required VoidCallback onRetry,
    required ScrollController scrollController,
    required bool isUpcoming,
    required String emptyDescription,
  }) {
    // Handle loading state
    if (state.runtimeType.toString().contains('Loading')) {
      return UiUtils.buildBigCardShimmer();
    }

    // Handle failure state
    if (state.runtimeType.toString().contains('Failure')) {
      return SingleChildScrollView(
        physics: Constant.scrollPhysics,
        child: Center(
          heightFactor: 2,
          child: SomethingWentWrong(
            errorMessage: state.errorMessage.toString(),
          ),
        ),
      );
    }

    // Handle success state
    if (state.runtimeType.toString().contains('Success')) {
      if (appointments.isEmpty) {
        return NoDataFound(
          title: 'noAppointments'.translate(context),
          description: emptyDescription,
          onTap: () {
            onRetry();
            if (isUpcoming) {
              _tabsLoaded[_upcomingTabIndex] = true;
            } else {
              _tabsLoaded[_previousTabIndex] = true;
            }
            setState(() {});
          },
        );
      }

      // Group appointments by date
      final groupedAppointments = _groupAppointmentsByDate(appointments);
      final sortedDateKeys = groupedAppointments.keys.toList()
        ..sort((a, b) => a.compareTo(b));

      return Column(
        children: [
          Expanded(
            child: ListView.builder(
              physics: Constant.scrollPhysics,
              controller: scrollController,
              padding: const EdgeInsets.all(16),
              itemCount: _getTotalItemCount(
                groupedAppointments,
                sortedDateKeys,
              ),
              itemBuilder: (context, index) => _buildListItem(
                context,
                index,
                groupedAppointments,
                sortedDateKeys,
                isUpcoming,
              ),
            ),
          ),
          if (isLoadingMore) ...[
            const SizedBox(height: 10),
            UiUtils.progress(
              height: 30.rh(context),
              width: 30.rw(context),
            ),
            const SizedBox(height: 30),
          ],
        ],
      );
    }

    return Container();
  }

  int _getTotalItemCount(
    Map<String, List<AppointmentModel>> groupedAppointments,
    List<String> sortedDateKeys,
  ) {
    var totalCount = 0;
    for (final dateKey in sortedDateKeys) {
      totalCount += 1; // Date header
      totalCount += groupedAppointments[dateKey]!.length; // Appointments
    }
    return totalCount;
  }

  Widget _buildListItem(
    BuildContext context,
    int index,
    Map<String, List<AppointmentModel>> groupedAppointments,
    List<String> sortedDateKeys,
    bool isUpcoming,
  ) {
    var currentIndex = 0;

    for (final dateKey in sortedDateKeys) {
      final appointments = groupedAppointments[dateKey]!;

      // Check if this index is the date header
      if (currentIndex == index) {
        return _buildDateHeader(context, dateKey);
      }
      currentIndex++;

      // Check if this index is within the appointments for this date
      for (var i = 0; i < appointments.length; i++) {
        if (currentIndex == index) {
          return AppointmentCard(
            appointment: appointments[i],
            isAgent: widget.isAgent,
            isFromPreviousAppointments: !isUpcoming,
          );
        }
        currentIndex++;
      }
    }

    return Container(); // Fallback
  }

  Widget _buildDateHeader(BuildContext context, String dateKey) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      margin: const EdgeInsets.only(bottom: 16),
      decoration: BoxDecoration(
        color: context.color.textColorDark.withValues(alpha: 0.1),
        borderRadius: BorderRadius.circular(4),
        border: Border.all(color: context.color.borderColor),
      ),
      child: CustomText(
        '${'date'.translate(context)}: ${_formatDateHeader(dateKey)}',
        fontSize: context.font.sm,
        fontWeight: FontWeight.w600,
        color: context.color.textColorDark,
      ),
    );
  }
}
