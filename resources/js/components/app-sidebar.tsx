import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { LayoutGrid, PhoneCall, PlugZap, Tv, Wifi } from 'lucide-react';
import AppLogoIcon from './app-logo-icon';
import AppLogoWordmark from './app-logo-wordmark';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        url: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Airtime Topup',
        url: route('airtime.create'),
        icon: PhoneCall,
    },
    {
        title: 'Data Topup',
        url: '/data',
        icon: Wifi,
    },
    {
        title: 'Electricity',
        url: '/electricity',
        icon: PlugZap,
    },
    {
        title: 'Cable/TV',
        url: '/cable-tv',
        icon: Tv,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Cable/TV',
        url: '/cable-tv',
        icon: Tv,
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" className="rounded-none" asChild>
                            <Link href="/dashboard" prefetch>
                                <div className="flex items-center gap-2">
                                    <div className="flex aspect-square size-8 items-center justify-center rounded-none">
                                        <AppLogoIcon className="text-primary size-8 fill-current dark:text-white" />
                                    </div>
                                    <div className="ml-1 grid flex-1 text-left text-sm">
                                        <AppLogoWordmark className="h-6 text-white" />
                                    </div>
                                </div>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
