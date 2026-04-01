import AuthContent from "../../components/auth/AuthContent";

const Login = () => {
  return (
    <div className="h-full grid place-items-center">
      <div className="w-full h-max overflow-y-auto sm:max-w-96 sm:border">
        <div className="px-8 pt-12 pb-6 border-b text-center">
          <h2 className="mb-2 font-bold text-primary-dark uppercase text-2xl">
            Welcome
          </h2>

          <p>Log in or create an account to continue</p>
        </div>

        <AuthContent />
      </div>
    </div>
  );
};

export default Login;
