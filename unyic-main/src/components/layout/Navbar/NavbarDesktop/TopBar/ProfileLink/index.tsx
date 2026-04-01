import { CgProfile } from "react-icons/cg";
import useModalById from "../../../../../../hooks/useModalById";

const ProfileLink = () => {
  const { openModalWithData: openAuthModal } = useModalById("authModal");

  return (
    <div className="relative group hidden lg:block" role="button">
      <CgProfile />

      {/* Dropdown */}
      <div className="absolute left-1/2 -translate-x-1/2 z-10 pt-4 hidden group-hover:block">
        {/* Triangle pointer for dropdown */}
        <span className="w-4 h-4 bg-light border border-e-0 border-b-0 absolute left-1/2 -translate-x-1/2 top-2 z-30 rotate-45" />

        <ul className="p-4 border bg-light space-y-3 w-36 relative">
          <li>
            <button
              onClick={() => openAuthModal({ activeTab: "login" })}
              className="w-full block py-2 border border-primary rounded text-lg font-semibold text-primary text-center"
            >
              Login
            </button>
          </li>

          <li>
            <button
              onClick={() => openAuthModal({ activeTab: "signup" })}
              className="w-full block py-2 border border-primary rounded text-lg font-semibold text-primary text-center"
            >
              Sign Up
            </button>
          </li>
        </ul>
      </div>
    </div>
  );
};

export default ProfileLink;
