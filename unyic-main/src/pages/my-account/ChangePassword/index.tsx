import ChangePasswordForm from "./ChangePasswordForm";

const ChangePassword = () => {
  return (
    <>
      <h3 className="mb-8 hidden lg:block text-xl font-semibold">
        Change Password
      </h3>

      <div className="max-w-md mx-auto p-6 lg:p-8 rounded bg-white">
        <h4 className="mb-6 text-center text-lg font-semibold">
          Create a new password
        </h4>

        <ChangePasswordForm />
      </div>
    </>
  );
};

export default ChangePassword;
