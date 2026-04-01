import Button from "../../../../ui/Button";

interface AuthSubmitButtonProps {
  isLoading: boolean;
  label: string;
}

const AuthSubmitButton = ({ isLoading, label }: AuthSubmitButtonProps) => {
  if (isLoading) {
    return (
      <Button type="button" disabled={true}>
        Loading...
      </Button>
    );
  }

  return <Button type="submit">{label}</Button>;
};

export default AuthSubmitButton;
