import clsx from "clsx";
import { Link } from "react-router";

interface ButtonProps {
  children: React.ReactNode;
  className?: string;
  variant?: "primary" | "primary-outline" | "dark";

  href?: string;

  onClick?: (event: React.MouseEvent<HTMLButtonElement>) => void;
  type?: "button" | "submit" | "reset";
  disabled?: boolean;
  form?: string;
}

const Button = ({
  children,
  className = "",
  variant = "primary",
  type = "button",
  onClick = () => {},
  disabled = false,
  href = "",
  form,
}: ButtonProps) => {
  const classes = clsx(
    className,
    "w-full py-2 rounded border hover:shadow-md font-semibold text-center",
    {
      "border-primary-dark bg-primary-dark disabled:bg-primary-light disabled:border-primary-light disabled:opacity-60 text-light":
        variant === "primary",

      "border-primary-dark text-primary-dark": variant === "primary-outline",

      "border-dark bg-dark disabled:bg-dark-light disabled:border-dark-light disabled:opacity-60 text-light":
        variant === "dark",
    }
  );

  // If href is provided, render a link
  if (href) {
    return (
      <Link to={href} className={clsx("block", classes)}>
        {children}
      </Link>
    );
  }

  return (
    <button
      onClick={onClick}
      className={classes}
      type={type}
      disabled={disabled}
      aria-disabled={disabled}
      {...(form ? { form } : {})}
    >
      {children}
    </button>
  );
};

export default Button;
