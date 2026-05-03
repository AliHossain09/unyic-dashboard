import { useForm, type SubmitHandler } from "react-hook-form";
import Button from "../../ui/Button";
import EmailField from "../../forms/shared/EmailField";
import { useForgotPasswordMutation } from "../../../store/features/auth/authApi";
import toast from "react-hot-toast";
import useModalById from "../../../hooks/useModalById";

interface Inputs {
  email: string;
}

const ForgotPasswordForm = () => {
  const [forgotPassword, { isLoading }] = useForgotPasswordMutation();
  const { closeModal } = useModalById("forgotPasswordModal");

  const {
    register,
    handleSubmit,
    reset,
    formState: { errors, isValid },
  } = useForm<Inputs>({
    mode: "onTouched",
  });

  const onSubmit: SubmitHandler<Inputs> = async (data) => {
    try {
      await forgotPassword(data).unwrap();
      reset();
      closeModal();
      toast.success("Password reset link sent to your email.");
    } catch (error) {
      const message =
        (error as { data?: { message?: string } })?.data?.message ||
        "Failed to send password reset link";

      toast.error(message);
      console.error("Failed to send password reset link:", error);
    }
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)} className="space-y-4" noValidate>
      <EmailField register={register} error={errors?.email} />

      <Button type="submit" disabled={!isValid || isLoading}>
        {isLoading ? "Sending..." : "Send Reset Link"}
      </Button>
    </form>
  );
};

export default ForgotPasswordForm;
