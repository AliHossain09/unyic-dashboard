import clsx from "clsx";

import { Link, useLocation } from "react-router";
import { accountMenuItems } from "../../../config/accountMenu";

const SidebarMenu = () => {
  const location = useLocation();

  return (
    <div className="h-full py-4 space-y-3">
      {accountMenuItems.map((item, index) => {
        const { Icon, href, label } = item || {};

        return (
          <Link
            key={index}
            to={href}
            className={clsx(
              "w-full p-3 rounded-md flex items-center gap-3",
              location.pathname === item.href
                ? "bg-primary/15 text-primary-dark"
                : "text-dark-light hover:bg-neutral-200/80 hover:text-dark",
            )}
          >
            <Icon size={18} />
            <span className="font-semibold text-sm">{label}</span>
          </Link>
        );
      })}
    </div>
  );
};

export default SidebarMenu;
