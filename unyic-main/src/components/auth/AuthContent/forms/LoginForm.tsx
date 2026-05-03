import { useForm, type SubmitHandler } from "react-hook-form";
import useModalById from "../../../../hooks/useModalById";
import { useLoginMutation } from "../../../../store/features/auth/authApi";
import type { ApiErrorResponse } from "../../../../types/api";
import EmailField from "../../../forms/shared/EmailField";
import PasswordField from "../../../forms/shared/PasswordField";
import SubmitButton from "../../../forms/shared/SubmitButton";
import CheckboxField from "../../../forms/shared/CheckboxField";
import { useLocation, useNavigate } from "react-router";

interface Inputs {
  email: string;
  password: string;
  rememberMe: boolean;
}

const LoginForm = () => {
  const navigate = useNavigate();
  const location = useLocation();

  const from = location.state?.from?.pathname || "/";

  const {
    register,
    handleSubmit,
    formState: { errors },
    reset,
  } = useForm<Inputs>();
  const { openModal: openForgotPasswordModal } = useModalById(
    "forgotPasswordModal",
  );
  const { closeModal: closeAuthModal } = useModalById("authModal");

  const [login, { isLoading, error, isSuccess }] = useLoginMutation();

  const handleForgotPasswordClick = () => {
    closeAuthModal();
    openForgotPasswordModal();
  };

  const onSubmit: SubmitHandler<Inputs> = async (data) => {
    try {
      await login(data).unwrap();

      closeAuthModal();
      reset();
      navigate(from, { replace: true });
    } catch (err) {
      console.error("Failed to logged user:", err);
    }
  };

  return (
    <>
      {error && (
        <div className="h-8 mb-3 bg-red-100 grid place-items-center text-sm text-red-600">
          <p>{(error as ApiErrorResponse)?.errors[0]}</p>
        </div>
      )}

      {isSuccess && (
        <div className="h-8 mb-3 bg-success/10 grid place-items-center text-sm text-success">
          <p>Logged in successfully!</p>
        </div>
      )}

      <form onSubmit={handleSubmit(onSubmit)} className="space-y-4" noValidate>
        <EmailField register={register} error={errors?.email} />

        <div className="relative">
          <PasswordField register={register} error={errors?.password} />

          <div className="text-end">
            <button
              type="button"
              className="text-sm mt-1 text-primary underline underline-offset-1"
              onClick={handleForgotPasswordClick}
            >
              Forgot Password?
            </button>
          </div>
        </div>

        <CheckboxField
          id="rememberMe"
          label="Remember me"
          registerProps={register("rememberMe")}
        />

        <SubmitButton
          isLoading={isLoading}
          label="Login"
          loadingLabel="Signing in..."
        />
      </form>
    </>
  );
};

export default LoginForm;
