import Button from "../../ui/Button";

interface SubmitButtonProps {
  isLoading: boolean;
  label: string;
  loadingLabel?: string;
  className?: string;
}

const SubmitButton = ({
  isLoading,
  label,
  loadingLabel = "Loading...",
  className,
}: SubmitButtonProps) => {
  return (
    <Button type="submit" className={className} disabled={isLoading}>
      {isLoading ? loadingLabel : label}
    </Button>
  );
};

export default SubmitButton;
