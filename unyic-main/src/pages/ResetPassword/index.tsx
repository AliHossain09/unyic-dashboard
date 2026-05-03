import { Link, useNavigate, useSearchParams } from "react-router";
import { useForm } from "react-hook-form";
import toast from "react-hot-toast";
import InputField from "../../components/forms/shared/InputField";
import SubmitButton from "../../components/forms/shared/SubmitButton";
import { useResetPasswordMutation } from "../../store/features/auth/authApi";

interface Inputs {
  password: string;
  passwordConfirmation: string;
}

const ResetPassword = () => {
  const [searchParams] = useSearchParams();
  const navigate = useNavigate();
  const [resetPassword, { isLoading }] = useResetPasswordMutation();

  const token = searchParams.get("token") || "";
  const email = searchParams.get("email") || "";

  const {
    register,
    handleSubmit,
    getValues,
    formState: { errors },
  } = useForm<Inputs>({
    mode: "onTouched",
  });

  const onSubmit = async (data: Inputs) => {
    if (!token || !email) {
      toast.error("Invalid password reset link");
      return;
    }

    try {
      await resetPassword({
        token,
        email,
        password: data.password,
        passwordConfirmation: data.passwordConfirmation,
      }).unwrap();

      toast.success("Password reset successfully. Please login.");
      navigate("/login");
    } catch (error) {
      toast.error("Failed to reset password");
      console.error("Failed to reset password:", error);
    }
  };

  return (
    <div className="h-full grid place-items-center px-4">
      <div className="w-full max-w-96 border">
        <div className="px-8 pt-12 pb-6 border-b text-center">
          <h2 className="mb-2 font-bold text-primary-dark uppercase text-2xl">
            Reset Password
          </h2>
          <p>Create a new password for your account</p>
        </div>

        <form
          onSubmit={handleSubmit(onSubmit)}
          className="px-8 py-6 space-y-4"
          noValidate
        >
          {!token || !email ? (
            <p className="text-sm text-red-600">Invalid password reset link.</p>
          ) : null}

          <InputField
            id="password"
            label="New Password"
            type="password"
            placeholder="Create a new password"
            registerProps={register("password", {
              required: "New password is required",
              minLength: {
                value: 8,
                message: "Password must be at least 8 characters long",
              },
            })}
            error={errors.password}
          />

          <InputField
            id="passwordConfirmation"
            label="Confirm New Password"
            type="password"
            placeholder="Re-enter your new password"
            registerProps={register("passwordConfirmation", {
              required: "Confirm password is required",
              validate: (value) =>
                value === getValues("password") ||
                "Confirm password do not match with new password",
            })}
            error={errors.passwordConfirmation}
          />

          <SubmitButton
            isLoading={isLoading}
            label="Reset Password"
            loadingLabel="Resetting..."
          />

          <Link
            to="/login"
            className="block text-center text-sm text-primary underline underline-offset-1"
          >
            Back to login
          </Link>
        </form>
      </div>
    </div>
  );
};

export default ResetPassword;
