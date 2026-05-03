import AuthContent from "../../auth/AuthContent";
import Logo from "../../ui/Logo";
import Modal from "../Modal";

const AuthModal = () => {
  return (
    <Modal
      modalId="authModal"
      containerClasses="h-screen md:h-auto w-full md:w-96 top-1/2 left-1/2 -translate-1/2"
    >
      <div className="p-6 pt-12 border-b">
        <div className="w-max mx-auto mb-2">
          <Logo />
        </div>

        <p className="text-center text-sm">
          India&apos;s most beautiful products
        </p>
      </div>

      <AuthContent />
    </Modal>
  );
};

export default AuthModal;
