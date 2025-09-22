import AppLogo from '@/components/app-logo';
import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { Bookmark, Box, Boxes, ChartNoAxesCombined, CircleDollarSign, Ruler, Tag, Users } from 'lucide-react';

const mainNavItems: NavItem[] = [
    {
        title: 'Panel de control',
        href: '/the-owl/public/panel',
        icon: ChartNoAxesCombined,
    },
    {
        title: 'Productos',
        href: '/the-owl/public/panel/productos',
        icon: Box,
    },
    {
        title: 'Categorias',
        href: '/the-owl/public/panel/categorias',
        icon: Bookmark,
    },
    {
        title: 'Marcas',
        href: '/the-owl/public/panel/marcas',
        icon: Tag,
    },
    {
        title: 'Tamaños',
        href: '/the-owl/public/panel/tamaños',
        icon: Ruler,
    },
    {
        title: 'Pedidos',
        href: '/the-owl/public/panel/pedidos',
        icon: Boxes,
    },
    {
        title: 'Usuarios',
        href: '/the-owl/public/panel/usuarios',
        icon: Users,
    },
    {
        title: 'Proveedores',
        href: '/the-owl/public/panel/proveedores',
        icon: CircleDollarSign,
    },
];

const footerNavItems: NavItem[] = [];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild isActive={false}>
                            <Link href="/the-owl/public/dashboard" prefetch>
                                <AppLogo />
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
