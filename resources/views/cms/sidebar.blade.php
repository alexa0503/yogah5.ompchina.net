<aside id="sidebar" class="page-sidebar hidden-md hidden-sm hidden-xs">
    <!-- Start .sidebar-inner -->
    <div class="sidebar-inner">
        <!-- Start .sidebar-scrollarea -->
        <div class="sidebar-scrollarea">
            <!-- .side-nav -->
            <div class="side-nav">
                <ul class="nav">
                    <li>
                        <a href="{{url('/cms')}}" class="{{ Request::is('cms') ? 'active' : '' }}"><i class="l-basic-laptop"></i><span class="txt">Dashboard</span></a>
                    </li>
                    <li>
                        <a href="javascript:;" class="{{ Request::is('cms/infos') || Request::is('cms/export/infos') ? 'expand active-state' : '' }}"><i class="l-basic-folder"></i> <span class="txt">信息管理</span></a>
                        <ul class="sub {{ Request::is('cms/infos') || Request::is('cms/export/infos') ? ' show' : '' }}">
                            <li><a href="{{url('/cms/infos')}}" class="{{ Request::is('cms/infos') ? 'active' : '' }}"><span class="txt">查看</span></a></li>
                                <li><a href="{{url('/cms/export/infos')}}" class="{{ Request::is('cms/infos/export') ? 'active' : '' }}"><span class="txt">导出</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{url('/cms/wechat')}}" class="{{ Request::is('cms/wechat') ? 'active' : '' }}"><i class="l-basic-laptop"></i><span class="txt">授权用户</span></a>
                    </li>
                </ul>
            </div>
            <!-- / side-nav -->
        </div>
        <!-- End .sidebar-scrollarea -->
    </div>
    <!-- End .sidebar-inner -->
</aside>
