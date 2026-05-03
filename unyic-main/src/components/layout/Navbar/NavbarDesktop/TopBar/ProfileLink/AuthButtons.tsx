import useModalById from "../../../../../../hooks/useModalById";

const AuthButtons = () => {
  const { openModalWithData: openAuthModal } = useModalById("authModal");

  return (
    <ul className="space-y-3">
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
  );
};

export default AuthButtons;
