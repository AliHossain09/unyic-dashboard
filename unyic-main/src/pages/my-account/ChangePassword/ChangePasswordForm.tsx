import { useForm } from "react-hook-form";
import InputField from "../../../components/forms/shared/InputField";
import SubmitButton from "../../../components/forms/shared/SubmitButton";
import { useChangePasswordMutation } from "../../../store/features/auth/authApi";
import toast from "react-hot-toast";

interface Inputs {
  currentPassword: string;
  newPassword: string;
  confirmPassword: string;
}

const ChangePasswordForm = () => {
  const [changePassword, { isLoading }] = useChangePasswordMutation();

  const {
    register,
    handleSubmit,
    getValues,
    reset,
    formState: { errors },
  } = useForm<Inputs>({
    mode: "onTouched",
  });

  const onSubmit = async (data: Inputs) => {
    try {
      await changePassword({
        currentPassword: data.currentPassword,
        newPassword: data.newPassword,
        confirmPassword: data.confirmPassword,
      }).unwrap();

      reset();
      toast.success("Password changed successfully!");
    } catch (error) {
      toast.error("Failed to change password");
      console.error("Failed to change password :", error);
    }
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)} className="space-y-4" noValidate>
      <InputField
        id="currentPassword"
        label="Current Password"
        type="password"
        placeholder="Enter your current password"
        registerProps={register("currentPassword", {
          required: "Current password is required",
        })}
        error={errors.currentPassword}
      />

      <InputField
        id="newPassword"
        label="New Password"
        type="password"
        placeholder="Create a new password"
        registerProps={register("newPassword", {
          required: "New password is required",
          minLength: {
            value: 8,
            message: "Password must be at least 8 characters long",
          },
          validate: (value) =>
            value !== getValues("currentPassword") ||
            "New password must be different from your current password",
        })}
        error={errors.newPassword}
      />

      <InputField
        id="confirmPassword"
        label="Confirm New Password"
        type="password"
        placeholder="Re-enter your new password"
        registerProps={register("confirmPassword", {
          required: "Confirm password is required",
          validate: (value) =>
            value === getValues("newPassword") ||
            "Confirm password do not match with new password",
        })}
        error={errors.confirmPassword}
      />

      <SubmitButton
        isLoading={isLoading}
        label="Change Password"
        loadingLabel="Updating password..."
        className="block max-w-44 ms-auto"
      />
    </form>
  );
};

export default ChangePasswordForm;
