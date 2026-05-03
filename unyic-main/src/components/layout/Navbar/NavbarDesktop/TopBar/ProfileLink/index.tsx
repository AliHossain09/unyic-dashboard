import { CgProfile } from "react-icons/cg";
import useUser from "../../../../../../hooks/useUser";
import AuthButtons from "./AuthButtons";
import ProfileDropdown from "./ProfileDropdown";
import clsx from "clsx";

const ProfileLink = () => {
  const { user, isUserLoading } = useUser();

  return (
    <div className="relative group hidden lg:block" role="button">
      <CgProfile className={clsx(isUserLoading && "opacity-50")} />

      {!isUserLoading && (
        <div className="absolute left-1/2 -translate-x-1/2 z-10 pt-4 hidden group-hover:block">
          {/* Triangle pointer for dropdown */}
          <span className="w-4 h-4 bg-light border border-e-0 border-b-0 absolute left-1/2 -translate-x-1/2 top-2 z-30 rotate-45" />

          <ul className="p-3 border bg-light w-40 relative">
            {user ? <ProfileDropdown user={user} /> : <AuthButtons />}
          </ul>
        </div>
      )}
    </div>
  );
};

export default ProfileLink;
