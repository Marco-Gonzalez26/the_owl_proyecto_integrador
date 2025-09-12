import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { SidebarMenu, SidebarMenuButton, SidebarMenuItem, useSidebar } from '@/components/ui/sidebar';
import { useIsMobile } from '@/hooks/use-mobile';
import { SharedData } from '@/types';
import { Link, router, usePage } from '@inertiajs/react';
import { DropdownMenuItem } from '@radix-ui/react-dropdown-menu';
import { ChevronsUpDown, LogOut, Settings, Store } from 'lucide-react';
import { Button } from './ui/button';

export function NavUser() {
    const { auth } = usePage<SharedData>().props;
    const { state } = useSidebar();
    const isMobile = useIsMobile();
    const logout = async () => {
        // Logout del usuario
        try {
            await router.post(route('logout'));
            return;
        } catch (error) {
            console.log(error);
        }
    };
    return (
        <SidebarMenu>
            <SidebarMenuItem>
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <SidebarMenuButton size="lg" className="group text-sidebar-accent-foreground data-[state=open]:bg-sidebar-accent">
                            <span className="flex items-center gap-2 rounded-lg px-4 py-2 text-sm text-sidebar-accent-foreground hover:bg-sidebar-accent">
                                <img src={'admin-avatar.png'} alt={auth.user.name} className="h-8 w-8 rounded-full" />
                                <span>{auth.user.name ?? 'Usuario'}</span>
                            </span>
                            <ChevronsUpDown className="ml-auto size-4" />
                        </SidebarMenuButton>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent
                        className="w-(--radix-dropdown-menu-trigger-width) min-w-56 rounded-lg"
                        align="end"
                        side={isMobile ? 'bottom' : state === 'collapsed' ? 'left' : 'bottom'}
                    >
                        <DropdownMenuItem asChild>
                            <Link href={route('dashboard')} prefetch>
                                <SidebarMenuButton className="flex items-center gap-2 rounded-lg px-4 py-2 text-sm text-sidebar-accent-foreground hover:bg-sidebar-accent">
                                    <Settings className="h-5 w-5 text-sidebar-accent-foreground" />
                                    <span>Configuración</span>
                                </SidebarMenuButton>
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem asChild>
                            <Link href={route('dashboard')} prefetch>
                                <SidebarMenuButton className="flex items-center gap-2 rounded-lg border-0 px-4 py-2 text-sm text-sidebar-accent-foreground hover:bg-sidebar-accent">
                                    <Store className="h-5 w-5 text-sidebar-accent-foreground" />
                                    <span>Ir a la página web</span>
                                </SidebarMenuButton>
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem asChild>
                            <Button onClick={logout} variant={'ghost'} className="w-full px-0">
                                <SidebarMenuButton className="flex items-center rounded-lg px-4 py-2 text-sm text-sidebar-accent-foreground hover:bg-sidebar-accent">
                                    <LogOut className="h-5 w-5 text-sidebar-accent-foreground" />
                                    <span>Cerrar sesión</span>
                                </SidebarMenuButton>
                            </Button>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </SidebarMenuItem>
        </SidebarMenu>
    );
}
