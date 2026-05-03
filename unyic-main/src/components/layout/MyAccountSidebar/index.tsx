import SidebarHeader from "./SidebarHeader";
import SidebarFooter from "./SidebarFooter";
import SidebarMenu from "./SidebarMenu";

const MyAccountSidebar = () => {
  return (
    <aside className="h-[calc(100dvh-var(--main-nav-h))] px-4 py-6 border-e flex flex-col">
      <SidebarHeader />
      <SidebarMenu />
      <SidebarFooter />
    </aside>
  );
};

export default MyAccountSidebar;
