import { useState } from "react";
import Button from "../../../../components/ui/Button";

const CommentBox = () => {
  const [comment, setComment] = useState("");

  const handleCommentSubmit = () => {
    // Handle comment submission
  };

  return (
    <div className="space-y-2">
      <h4 className="mt-8 text-2xl text-dark-light">Leave a comment</h4>

      <div className="border">
        <div className="p-4">
          <textarea
            name="comment"
            rows={6}
            placeholder="Write a comment..."
            className="bg-transparent w-full focus:outline-none"
            value={comment}
            onChange={(e) => setComment(e.target.value)}
          />
        </div>

        <div className="p-4 border-t text-end">
          <Button
            onClick={handleCommentSubmit}
            className="w-max px-4"
            disabled={!comment}
          >
            Comment
          </Button>
        </div>
      </div>
    </div>
  );
};

export default CommentBox;
